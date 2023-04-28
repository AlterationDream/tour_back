<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:currencies,name',
            'short_name' => 'required|string|unique:currencies,short_name'
        ])->validate();

        Currency::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
        ]);

        return Response::json(['success' => true, 'result' => 'Валюта успешно добавлена!']);
    }

    public function update(Request $request) {
        Validator::make($request->all(), [
            'id' => 'required|exists:currencies,id',
            'name' => 'required|string|unique:currencies,name,'.$request->id,
            'short_name' => 'required|string|unique:currencies,short_name,'.$request->id
        ])->validate();

        $currency = Currency::find($request->id);
        $currency->fill([
            'name' => $request->name,
            'short_name' => $request->short_name
        ]);
        $currency->save();

        return Response::json(['success' => true, 'result' => 'Валюта успешно изменена!']);
    }

    public function delete(Request $request): string|null
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $currency = Currency::find($id);
            if (!$currency) {
                return Response::json(['message' => 'Валюта не найдена!'], 404);
            }
            $currency->delete();
            return Response::json(['success' => true, 'result' => 'Валюта успешно удалена!']);
        } return null;
    }

    public function getList(Request $request): ?string
    {
        if ($request->ajax()) {
            $currencies = Currency::all();
            return view('services.includes.simple-list', [
                'listings' => $currencies,
                'modalName' => 'CurrencyModal',
                'deleteName' => 'эту валюту',
                'newName' => 'новую валюту'
            ])->render();
        } return null;
    }

    public function getCurrencies(): JsonResponse
    {
        $currencies = Currency::all();
        return response()->json($currencies);
    }
}
