<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::all();
        return response()->json($tariffs);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ration_name' => 'required|string',
            'cooking_day_before' => 'required|boolean',
        ]);

        $tariff = Tariff::create($validatedData);
        return response()->json($tariff, 201);
    }
}
