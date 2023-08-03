<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function OrderHistory()
    {
        return view('admin.order-history');
    }
}
