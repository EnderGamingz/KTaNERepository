<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cache;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = Cache::get('tags');
        
        return response()->json($tags);
    }
}
