<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sub_categorie;

class productsubCategorycontrooler extends Controller
{
    public function index(Request $request)
    {
        if(!empty($request->category_id)){
            $subCategory = sub_categorie::where('category_id',$request->category_id)
            ->orderBy('name','ASC')
            ->get();

            return resposne()->json([
                'status' => true,
                'subCategory' => $subCategory
            ]);
        } else{
            return resposne()->json([
                'status' => true,
                'subCategory' => []
            ]);
            
        }
    }
}
