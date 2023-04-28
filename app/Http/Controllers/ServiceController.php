<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Place;
use App\Models\PriceUnit;
use App\Models\SaleTag;
use App\Models\Service;
use App\Models\ServicesCategory;
use App\Traits\ImageStorageTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    use ImageStorageTrait;
    static $imageFolder = 'services-images';

    public function index() {
        $categories = $this->getCategories();
        $services = Service::paginate(9);
        return view('services.listings.index', compact('categories', 'services'));
    }

    public function create() {
        //region Get Variables
        $categories = $this->getCategories();
        $currencies = Currency::orderBy('name')->get();
        $units = PriceUnit::orderBy('name')->get();
        $countries = Place::where('parent_id', 0)->orderBy('name')->get();
        $cities = Place::where('parent_id', '!=', 0)->orderBy('name')->get();
        $saleTags = SaleTag::orderBy('name')->get();
        //endregion

        return view('services.listings.create',
            compact('categories', 'currencies', 'units', 'countries', 'cities', 'saleTags')
        );
    }

    public function store(Request $request) {
        //region Validate Request
        $v = Validator::make($request->all(), [
            'name' => 'required|string|unique:services,name',
            'category' => 'required|integer|exists:services_categories,id',
            'price_value' => 'required|numeric',
            'price_currency' => 'required|integer|exists:currencies,id',
            'price_unit' => 'required|integer',
            'country' => 'required|integer',
            'city' => 'required|integer',
            'sale_tag' => 'required|integer',
            'description' => 'required|string',
            'images' => 'required',
            'images.*' => 'file',
            'image_order' => 'required|string'
        ]);
        $v->sometimes('price_unit', 'exists:price_units,id', function ($input) {
            return $input->price_unit != '0';
        });
        $v->sometimes('country', 'exists:places,id', function ($input) {
            return $input->country != '0';
        });
        $v->sometimes('city', 'exists:places,id', function ($input) {
            return $input->city != '0';
        });
        $v->sometimes('sale_tag', 'exists:sale_tags,id', function ($input) {
            return $input->sale_tag != '0';
        });
        $v->validate();
        //endregion
        //region Set Props
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'services_category_id' => $request->category,
            'description' => $request->description,
            'price_value' => $request->price_value,
            'currency_id' => $request->price_currency,
            'price_unit_id' => $request->price_unit,
            'sale_tag_id' => $request->sale_tag,
            'country_id' => $request->country,
            'city_id' => $request->city_id,
        ];
        //endregion

        $props['images'] = $this->storeImages($request->image_order, $request->file('images'));

        Service::create($props);
        return redirect()->route('services')->with('success', 'Услуга успешно добавлена!');
    }

    public function edit($id) {
        $service = Service::find($id);
        if (!$service) return back()->withErrors('Услуга не найдена');
        //region Get Variables
        $images = explode(', ', $service->images);
        $categories = $this->getCategories();
        $currencies = Currency::orderBy('name')->get();
        $units = PriceUnit::orderBy('name')->get();
        $countries = Place::where('parent_id', 0)->orderBy('name')->get();
        $cities = Place::where('parent_id', '!=', 0)->orderBy('name')->get();
        $saleTags = SaleTag::orderBy('name')->get();
        //endregion

        return view('services.listings.edit',
            compact('service', 'images', 'categories', 'currencies', 'units', 'countries', 'cities', 'saleTags')
        );
    }

    public function update($id, Request $request) {
        $service = Service::find($id);
        if (!$service) return back()->withErrors('Услуга не найдена');

        // region Request Validation
        $v = Validator::make($request->all(), [
            'name' => 'required|string|unique:services,name,'.$id,
            'category' => 'required|integer|exists:services_categories,id',
            'price_value' => 'required|numeric',
            'price_currency' => 'required|integer|exists:currencies,id',
            'price_unit' => 'required|integer',
            'country' => 'required|integer',
            'city' => 'required|integer',
            'sale_tag' => 'required|integer',
            'description' => 'required|string',
            'images.*' => 'file',
            'image_order' => 'required|string'
        ]);
        $v->sometimes('price_unit', 'exists:price_units,id', function ($input) {
            return $input->price_unit != '0';
        });
        $v->sometimes('country', 'exists:places,id', function ($input) {
            return $input->country != '0';
        });
        $v->sometimes('city', 'exists:places,id', function ($input) {
            return $input->city != '0';
        });
        $v->sometimes('sale_tag', 'exists:sale_tags,id', function ($input) {
            return $input->sale_tag != '0';
        });
        $v->validate();

        // endregion
        //region Fill Props
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'services_category_id' => $request->category,
            'description' => $request->description,
            'price_value' => $request->price_value,
            'currency_id' => $request->price_currency,
            'price_unit_id' => $request->price_unit,
            'sale_tag_id' => $request->sale_tag,
            'country_id' => $request->country,
            'city_id' => $request->city_id,
        ];
        if ($request->hasFile('images')) {
            $props['images'] = $this->storeImages($request->image_order, $request->file('images'));
        } else {
            $imageOrder = explode(',', $request->image_order);
            foreach ($imageOrder as &$order) {
                $order--;
            }

            $images = explode(', ', $service->images);
            $images = array_replace(array_flip($imageOrder), $images);
            $props['images'] = implode(', ', $images);
        }
        $service->fill($props);
        $service->save();
        //endregion

        return redirect()->route('services')->with('success', 'Услуга успешно обновлена!');
    }

    public function delete($id) {
        $service = Service::find($id);
        if (!$service) return back()->withErrors('Услуга не найдена');

        $images = explode(', ', $service->images);
        foreach ($images as $image) {
            $this->deleteImage($image, self::$imageFolder);
        }
        $service->delete();
        return redirect()->route('services')->with('success', 'Услуга успешно удалена!');
    }

    public function settings() {
        $places = Place::all();
        $currencies = Currency::all();
        $priceUnits = PriceUnit::all();
        $saleTags = SaleTag::all();
        return view('services.settings', compact('places', 'currencies', 'priceUnits', 'saleTags'));
    }

    public function getList(Request $request): string|null
    {
        if ($request->ajax()) {
            $categoryID = $request->get('category');
            if ($categoryID != 0) {
                $services = Service::where('services_category_id', $categoryID)->orderBy('name')->paginate(9);
            } else {
                $services = Service::orderBy('name')->paginate(9);
            }
            return view('services.listings.tiles', compact('services'))->render();
        } return null;
    }

    private function storeImages($image_order, $request_images) {
        $imageOrder = explode(',', $image_order);
        foreach ($imageOrder as &$order) {
            $order--;
        }

        $imageList = '';
        $images = $request_images;
        $images = array_replace(array_flip($imageOrder), $images);

        $imagesKeys = array_keys($images);
        $lastKey = end($imagesKeys);
        foreach ($images as $key => $image) {
            $imageList .= $this->storeImage($image, self::$imageFolder);
            if ($key !== $lastKey) {
                $imageList .= ', ';
            }
        }
        return $imageList;
    }

    private function getCategories() {
        $categories = ServicesCategory::orderBy('parent_id', 'ASC')->orderBy('order', 'ASC')->get();
        foreach ($categories as $category) {
            if ($category->parent_id != 0) {
                $categoryName = $category->name;
                $categoryParent = ServicesCategory::find($category->parent_id);
                $categoryName = $categoryParent->name . ' — ' . $categoryName;
                if ($categoryParent->parent_id != 0) {
                    $categoryGreatParent = ServicesCategory::find($categoryParent->parent_id);
                    $categoryName = $categoryGreatParent->name . ' — ' . $categoryName;
                }
                $category->name = $categoryName;
            }
        }
        return $categories;
    }

    public function getCategoryListings($id): JsonResponse
    {
        $services = Service::where([['services_category_id', $id], ['active', 1]])->orderBy('name')->get();
        return response()->json($services);
    }
}
