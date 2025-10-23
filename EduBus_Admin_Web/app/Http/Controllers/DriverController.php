<?php

namespace App\Http\Controllers;
use App\Services\ApiService;

class DriverController extends Controller{
    public function index(ApiService $api)
    {
        $users = $api->getDrivers();
        return view('users.divers.driver-list', compact('users'));
    }
}
