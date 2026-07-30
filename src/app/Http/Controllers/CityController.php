<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('Name')->get();
        return view('welcome', compact('countries'));
    }

    public function byCountry($code)
    {
        $cities = City::where('CountryCode', $code)
            ->orderBy('Population', 'desc')
            ->get(['Name', 'Population']);

        return response()->json($cities);
    }
}