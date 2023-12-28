<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\brand;

class ProductController extends Controller
{


    public function index(){
        return view('admin.product.list');
    }
    public function create()
    {
        $data = [];
        $categories = Category::orderBy('name','ASC')->get();
        $brands = brand::orderBy('name','ASC')->get();
        $data['categories'] =$categories;
        $data['brands'] =$brands;
        return view('admin.product.creat', $data);
    }
    

}
