<?php

namespace App\Http\Controllers;

use App\Models\PriceUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PriceUnitController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:price_units,name',
        ])->validate();

        PriceUnit::create([
            'name' => $request->name,
        ]);

        return Response::json(['success' => true, 'result' => 'Единица измерения цены успешно добавлена!']);
    }

    public function update(Request $request) {
        Validator::make($request->all(), [
            'id' => 'required|exists:price_units,id',
            'name' => 'required|string|unique:price_units,name,'.$request->id,
        ])->validate();

        $priceUnit = PriceUnit::find($request->id);
        $priceUnit->fill([
            'name' => $request->name
        ]);
        $priceUnit->save();

        return Response::json(['success' => true, 'result' => 'Единица измерения цены успешно изменена!']);
    }

    public function delete(Request $request): string|null
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $priceUnit = PriceUnit::find($id);
            if (!$priceUnit) {
                return Response::json(['message' => 'Единица измерения цены не найдена!'], 404);
            }
            $priceUnit->delete();
            return Response::json(['success' => true, 'result' => 'Единица измерения цены успешно удалена!']);
        } return null;
    }

    public function getList(Request $request): string
    {
        if ($request->ajax()) {
            $priceUnits = PriceUnit::all();
            return view('services.includes.simple-list', [
                'listings' => $priceUnits,
                'modalName' => 'PriceUnitModal',
                'deleteName' => 'эту валюту',
                'newName' => 'новую валюту'
            ])->render();
        }
    }

    public function getPriceUnits(): JsonResponse
    {
        $priceUnits = PriceUnit::all();
        return response()->json($priceUnits);
    }
}
