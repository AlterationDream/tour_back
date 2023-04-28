<?php

namespace App\Http\Controllers;

use App\Models\ServicesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImageStorageTrait;
use Illuminate\Http\JsonResponse;

class ServicesCategoryController extends Controller
{
    use ImageStorageTrait;
    static $imageFolder = 'services-categories-images';

    public function index() {
        $parentCategories = ServicesCategory::where('parent_id', 0)->orderBy('order', 'ASC')->get();
        if (count($parentCategories) > 0) {
            $firstID = $parentCategories->pluck('id')->first();
            $childCategories = ServicesCategory::where('parent_id', $firstID)->orderBy('order', 'ASC')->get();
            if (count($childCategories) > 0) {
                $idList = $childCategories->pluck('id')->toArray();
                $subCategories = ServicesCategory::whereIn('parent_id', $idList)->get();
                $childCategories = $childCategories->merge($subCategories);
            }
        } else {
            $childCategories = [];
        }
        $selected = 0;

        return view('services.categories.index', compact('parentCategories', 'childCategories', 'selected'));
    }
    public function store(Request $request) {
        //region Validate Request
        $v = Validator::make($request->all(), [
            'name' => 'required|unique:services_categories,name',
            'parent_id' => 'required|integer',
            'after' => 'required|integer',
        ],[
            'shape.in' => 'Выберите форму карточки категории',
        ]);
        $v->sometimes('image', 'required|image', function ($input) {
            return $input->parent_id != '0';
        });
        $v->sometimes('shape', 'required|in:full,half,small', function ($input) {
            return $input->parent_id != 0;
        });
        $v->validate();
        //endregion
        //region Change Categories Order
        $serviceCategories = ServicesCategory::where([
            ['parent_id', $request->parent_id],
            ['order', '>', $request->after]])->get();
        foreach ($serviceCategories as $category) {
            ++$category->order;
            $category->save();
        }
        //endregion
        //region Create Category
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'order' => intval($request->after) + 1
        ];
        if (isset($request->image)) {
            $props['image'] = $this->storeImage($request->file('image'), self::$imageFolder);
        }
        if (isset($request->shape)) {
            $props['shape'] = $request->shape;
        }
        ServicesCategory::create($props);
        //endregion

        return Response::json(['success' => true, 'result' => 'Категория успешно добавлена!']);
    }
    public function update(Request $request) {
        $category = ServicesCategory::find($request->id);
        if (!$category) return back()->withErrors('Категория не найдена');
        //region Validate Request
        $v = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required|unique:services_categories,name,' . $request->id,
            'parent_id' => 'required|integer', //|exists:services_categories,id,' . $request->id,
            'after' => 'required|integer',//|exists:services_categories,order,parent_id,' . $request->parent_id,
        ], [
            'shape.in' => 'Выберите форму карточки категории!',
        ]);
        $v->sometimes('image', 'required|image', function ($input) {
            return $input->parent_id == 0;
        });
        $v->sometimes('image', 'nullable|image', function ($input) {
            return $input->parent_id != 0;
        });
        $v->sometimes('shape', 'required|in:full,half,small', function ($input) {
            return $input->parent_id != 0;
        });
        $v->validate();

        if ($request->parent_id != 0) {
            $parentCat = ServicesCategory::find($request->parent_id);
            if (!$parentCat) return Response::json(['message' => 'Родительская категория не найдена!'], 404);
        }
        //endregion
        //region Change Categories Order
        $order = intval($request->after) + 1;
        if ($category->order != $order) {
            if ($order > $category->order) {
                $serviceCategories = ServicesCategory::where([['parent_id', $request->parent_id],
                    ['order', '>', $order]])->orWhere([['parent_id', $request->parent_id],
                    ['order', '<=', $order]])->get();
                foreach ($serviceCategories as $movedCategory) {
                    --$movedCategory->order;
                    $movedCategory->save();
                }
                --$order;
            } else {
                $serviceCategories = ServicesCategory::where([['parent_id', $request->parent_id],
                    ['order', '<', $order]])->orWhere([['parent_id', $request->parent_id],
                    ['order', '>=', $order]])->get();
                foreach ($serviceCategories as $movedCategory) {
                    ++$movedCategory->order;
                    $movedCategory->save();
                }
            }
        }
        //endregion
        //region Update Category
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'order' => $order
        ];
        if (isset($request->image)) {
            $prop['image'] = $this->replaceImage($request->file('image'), $category->image, self::$imageFolder);
        }
        if (isset($request->shape)) {
            $props['shape'] = $request->shape;
        }

        $category->fill($props);
        $category->save();
        //endregion

        return Response::json(['success' => true, 'result' => 'Категория успешно изменена!']);
    }

    public function delete(Request $request) {
        if ($request->ajax()) {
            $id = $request->get('id');
            $category = ServicesCategory::where('id', $id)->get();
            if (!$category) {
                return Response::json(['message' => 'Категория не найдена!'], 404);
            }
            $this->recursiveDelete($category);
            return Response::json(['success' => true, 'result' => 'Категория успешно удалена!']);
        } return null;
    }

    /**
     * Delete categories and their children with the attached images.
     * @param $categories - List of categories to delete.
     */
    private function recursiveDelete($categories) {
        foreach ($categories as $category) {
            $subCategories = ServicesCategory::where('parent_id', $category->id)->get();
            if (count($subCategories) > 0) $this->recursiveDelete($subCategories);
            $this->deleteImage($category->image, self::$imageFolder);
            $category->delete();
        }
    }

    /**
     * Get a list of categories by a set of parameters
     * @param Request $request = [<br>
     *          &emsp;'current'   => (integer) Current category (if edited).<br/>
     *          &emsp;'parent_id' => (integer) Common parent ID of the listed categories.<br/>
     *          &emsp;'include'   => (string) Include file to render raw data.<br/>
     *          &emsp;'varname'   => (string) Name of the variable in the include file.<br/>
     *      ]
     * @return string Blade HTML (string)
     */
    public function getList(Request $request): string
    {
        if ($request->ajax()) {
            //region Read Request Variables
            $currentCategory = $request->get('current');
            $parent_id = $request->get('parent_id');
            $include = $request->get('include');
            $varname = $request->get('varname');
            $where = [['id', '!=', $currentCategory], ['parent_id', $parent_id]];
            //endregion
            //region Include Sub-Categories
            if ($include == 'services.categories.includes.child-categories') {
                $topCategories = ServicesCategory::where($where)->get();
                if (count($topCategories) > 0) {
                    $idList = $topCategories->pluck('id')->toArray();
                    $subCategories = ServicesCategory::whereIn('parent_id', $idList)->get();
                    $categories = $topCategories->merge($subCategories);
                } else {
                    $categories = $topCategories;
                }
            } else {
                $categories = ServicesCategory::where($where)->orderBy('order', 'ASC')->get();
            }
            //endregion

            if ($currentCategory != 0 && $include == 'services.categories.includes.order-select') {
                $currentCat = ServicesCategory::find($currentCategory);
                return view($include)->with($varname, $categories)->with('selected', $currentCat->order - 1)->render();
            }
            return view($include, [$varname => $categories])->render();
        }
    }

    public function getTopCategories(): JsonResponse
    {
        $categories = ServicesCategory::where([['parent_id', 0], ['active', 1]])->orderBy('order')->get();
        foreach ($categories as $topCat) {
            $children = ServicesCategory::where([['parent_id', $topCat->id], ['active', 1]])->orderBy('order')->get();
            $categories = $categories->merge($children);
        }
        return response()->json($categories);
    }

    public function getChildCategories($id): JsonResponse
    {
        $categories = ServicesCategory::where([['parent_id', $id], ['active', 1]])->orderBy('order')->get();
        return response()->json($categories);
    }
}
