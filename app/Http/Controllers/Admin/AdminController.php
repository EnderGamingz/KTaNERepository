<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Shows the admin dashboard
     * @param Request The HTTP Request
     * @return View The admin dashboard view
     */
    public function index(Request $request)
    {
        // Checks if the user has the right permissions
        if(!$request->user()->hasPermission('view.admin.dashboard')) {
            abort(402);
            return;
        }

        return view('admin.index');
    }
}
