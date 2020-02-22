<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        $api_key = config('myconfig.api_key');
        $auto_complete = "https://barikoi.xyz/v1/api/search/autocomplete/{$api_key}/place?q=";
        return view('master',compact('auto_complete','api_key'));
    }

    public function showDetails(Request $request){
        return $request->all();
    }
}
