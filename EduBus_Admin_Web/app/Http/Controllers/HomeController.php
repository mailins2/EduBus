<?php

namespace App\Http\Controllers;
use App\Services\ApiService;

class HomeController extends Controller{
    public function index(ApiService $api)
    {
        return view('home');
    }
}
