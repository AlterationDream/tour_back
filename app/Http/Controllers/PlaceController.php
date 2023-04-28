<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class PlaceController extends Controller
{
    public function store(Request $request) {
        //region Validate Request
        Validator::make($request->all(), [
            'name' => 'required|string|unique:places,name',
            'parent_id' => 'required|integer',
        ])->validate();
        // endregion

        Place::create([
            'active' => $request->has('active'),
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        return Response::json(['success' => true, 'result' => 'Место успешно добавлено!']);
    }

    public function update(Request $request) {
        //region Validate Request
        Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required|unique:places,name,' . $request->id,
            'parent_id' => 'required|integer',
        ])->validate();

        if ($request->parent_id != 0) {
            $country = Place::find($request->parent_id);
            if (!$country) return Response::json(['message' => 'Страна не найдена!'], 404);
        }
        //endregion

        $place = Place::find($request->id);
        $place->fill([
            'active' => $request->has('active'),
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        $place->save();

        return Response::json(['success' => true, 'result' => 'Место успешно обновлено!']);
    }

    public function delete(Request $request) {
        if ($request->ajax()) {
            $id = $request->get('id');
            $place = Place::where('id', $id)->get();
            if (!$place) {
                return Response::json(['message' => 'Место не найдено!'], 404);
            }
            $this->recursiveDelete($place);
            return Response::json(['success' => true, 'result' => 'Место успешно удалено!']);
        } return null;
    }

    /**
     * Delete categories and their children with the attached images.
     * @param $places - List of categories to delete.
     */
    private function recursiveDelete($places) {
        foreach ($places as $place) {
            $cities = Place::where('parent_id', $place->id)->get();
            if (count($cities) > 0) $this->recursiveDelete($cities);
            $place->delete();
        }
    }

    public function getList(Request $request): string
    {
        if ($request->ajax()) {
            $places = Place::all();
            return view('services.includes.places-list', ['places' => $places])->render();
        }
    }

    public function getPlaces(): JsonResponse
    {
        $places = Place::all();
        return response()->json($places);
    }
}
