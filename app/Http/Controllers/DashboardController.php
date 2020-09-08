<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $modules = Cache::get('modules')
            ->filter(function($data) use ($userId) {
                return ($data->maintainer && $data->maintainer->contains("id", $userId)) || $data->publisher_id == $userId;
            });
        return view('dashboard', ['modules' => $modules]);
    }
}
