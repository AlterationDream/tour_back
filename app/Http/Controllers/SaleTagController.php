<?php

namespace App\Http\Controllers;

use App\Models\SaleTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SaleTagController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:sale_tags,name',
            'color' => 'required|string',
        ])->validate();

        SaleTag::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return Response::json(['success' => true, 'result' => 'Метка распродажи успешно добавлена!']);
    }

    public function update(Request $request) {
        Validator::make($request->all(), [
            'id' => 'required|exists:sale_tags,id',
            'name' => 'required|string|unique:sale_tags,name,'.$request->id,
            'color' => 'required|string',
        ])->validate();

        $saleTag = SaleTag::find($request->id);
        $saleTag->fill([
            'name' => $request->name,
            'color' => $request->color,
        ]);
        $saleTag->save();

        return Response::json(['success' => true, 'result' => 'Метка распродажи цены успешно изменена!']);
    }

    public function delete(Request $request): string|null
    {
        if ($request->ajax()) {
            $id = $request->get('id');
            $saleTag = SaleTag::find($id);
            if (!$saleTag) {
                return Response::json(['message' => 'Метка распродажи цены не найдена!'], 404);
            }
            $saleTag->delete();
            return Response::json(['success' => true, 'result' => 'Метка распродажи цены успешно удалена!']);
        } return null;
    }

    public function getList(Request $request): string|null
    {
        if ($request->ajax()) {
            $saleTags = SaleTag::all();
            return view('services.includes.saletags-list', ['saleTags' => $saleTags])->render();
        } return null;
    }

    public function getSaleTags(): JsonResponse
    {
        $tags = SaleTag::all();
        return response()->json($tags);
    }
}
