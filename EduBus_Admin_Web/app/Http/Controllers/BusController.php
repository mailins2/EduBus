<?php

namespace App\Http\Controllers;
use App\Services\ApiService;

class BusController extends Controller{
    public function index(ApiService $api)
    {
        $buses = $api->getBuses();
        return view('busline.bus-list', compact('buses'));
    }
}
