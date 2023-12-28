<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    //
    public function index()
    {
        return view('admin.discount.discount');
    }
    public function user_ifno()
    {
        return view('admin.users.user');
    }
    public function page()
    {
        return view('admin.users.page');
    }
    public function create_page()
    {
        return view('admin.users.create_page');
    }
}
