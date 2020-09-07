<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // TODO Make modules dynamic
        $modules = [];
        return view('dashboard', ['modules' => $modules]);
    }
}
