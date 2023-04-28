<?php
namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImageStorageTrait;

class TourController extends Controller
{
    use ImageStorageTrait;
    static string $imagesFolder = 'tour-images';

    public function index() {
        $tours = Tour::paginate(9);
        return view('tours.index', compact('tours'));
    }

    public function create() {
        return view('tours.create');
    }

    public function edit($id) {
        $tour = Tour::find($id);
        if (!$tour) return back()->withErrors('Тур не найден');

        $tour->categories = explode(', ', $tour->categories);
        return view('tours.edit', compact('tour', 'id'));
    }

    public function store(Request $request) {
        //region Validate Request
        Validator::make($request->all(), [
            'name' => 'required|unique:tours|max:255',
            'categories' => 'required|array',
            'duration' => 'nullable|max:128',
            'starting' => 'nullable|max:128',
            'schedule' => 'nullable|max:128',
            'pricing' => 'nullable|max:128',
            'length' => 'nullable|max:128',
            'video' => 'nullable|max:128',
            'short_description' => 'required|max:256',
            'program' => 'required|max:4000',
            'additional' => 'required|max:4000',
            'booking' => 'required|max:4000',
            'image' => 'required|image'
        ],[
            'categories.array' => 'Нарушена структура формы',
            'categories.required' => 'Выберите хотя бы одну категорию',
        ])->validate();
        //endregion
        //region Fill Props
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'categories' => implode(', ', $request->categories),
            'duration' => $request->duration,
            'starting' => $request->starting,
            'schedule' => $request->schedule,
            'pricing' => $request->pricing,
            'length' => $request->length,
            'video' => $request->video,
            'short_description' => $request->short_description,
            'program' => $request->program,
            'additional' => $request->additional,
            'booking' => $request->booking,
        ];

        $props['image'] = $this->storeImage(
            $request->file('image'), self::$imagesFolder
        );
        //endregion

        Tour::create($props);
        return redirect()->route('tours')->with('success', 'Тур успешно добавлен!');
    }

    public function update(Request $request, $id) {
        $tour = Tour::find($id);
        if (!$tour) return back()->withErrors('Тур не найден');

        //region Validate Request
        Validator::make($request->all(), [
            'name' => 'required|unique:tours,name,'. $id .'|max:255',
            'categories' => 'required|array',
            'duration' => 'required|max:128',
            'starting' => 'required|max:128',
            'schedule' => 'required|max:128',
            'pricing' => 'required|max:128',
            'length' => 'nullable|max:128',
            'video' => 'nullable|max:128',
            'short_description' => 'required|max:256',
            'program' => 'required|max:1024',
            'additional' => 'required|max:1024',
            'booking' => 'required|max:1024',
            'image' => 'nullable|image'
        ],[
            'categories.array' => 'Нарушена структура формы',
            'categories.required' => 'Выберите хотя бы одну категорию',
        ])->validate();
        //endregion
        //region Set Props
        $props = [
            'active' => $request->has('active'),
            'name' => $request->name,
            'categories' => implode(', ', $request->categories),
            'duration' => $request->duration,
            'starting' => $request->starting,
            'schedule' => $request->schedule,
            'pricing' => $request->pricing,
            'length' => $request->length,
            'video' => $request->video,
            'short_description' => $request->short_description,
            'program' => $request->program,
            'additional' => $request->additional,
            'booking' => $request->booking,
        ];

        if ($request->image) {
            $props['image'] = $this->replaceImage(
                $request->file('image'), $tour->image, self::$imagesFolder
            );
        }
        //endregion

        $tour->fill($props);
        $tour->save();
        return redirect()->route('tours')->with('success', 'Тур "' . $tour->name . '" успешно обновлён!');
    }

    public function delete($id) {
        $tour = Tour::find($id);
        if (!$tour) return back()->withErrors('Тур не найден');

        $this->deleteImage($tour->image, self::$imagesFolder);
        $tour->delete();
        return redirect()->route('tours')->with('success', 'Тур успешно удалён!');
    }

    public function searchTours(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            $category = $request->get('category');
            $query = str_replace(" ", "%", $query);
            $tours = \DB::table('tours')
                ->where([
                    ['name', 'like', '%'.$query.'%'],
                    ['categories', 'like', '%'.$category.'%']])
                ->paginate(9);
            return view('tours.tiles', compact('tours'))->render();
        } return null;
    }

    public function getTours() {
        $tours = Tour::all();
        return response()->json($tours);
    }

    public function getTourDetails($id) {
        $tour = Tour::find($id);
        return response()->json($tour);
    }
}
