<?php

namespace App\Http\Controllers;
use App\Services\ApiService;

class StudentController extends Controller{
    public function index(ApiService $api)
    {
        $users = $api->getStudents();
        return view('users.students.student-list', compact('users'));
    }
}
