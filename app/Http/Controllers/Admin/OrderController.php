<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('admin.orders.order');
    }
    public function order_detail()
    {
         return view('admin.orders.detail');
    }
}
