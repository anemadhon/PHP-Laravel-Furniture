<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function getServices(Request $request)
    {
        return Http::post('https://api.rajaongkir.com/starter/cost', [
            'key' => config('services.rajaongkir.key'),
            'origin' => '455',
            'destination' => '107',
            'weight' => 10000,
            'courier' => $request->courier
        ]);
    }
}
