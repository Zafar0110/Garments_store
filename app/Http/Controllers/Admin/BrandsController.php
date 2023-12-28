<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brand;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{
    //
    public function index(Request $request)
    {
        $brands = brand::latest('id');

        if($request->get('keyword'))
        {
            $brands = $brands->where('name','like','%'.$request->keyword.'%');
        }

        $brands = $brands->paginate(10);
        return view('admin.brands.brand_list',compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'slug' => 'required|unique:brands',
             ]);

             if($validator->passes()){
                $brand = new brand();
                $brand->name = $request->name;
                $brand->slug = $request->slug;
                $brand->status = $request->status;
                $brand->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Brand added successfully:'
                ]);


             } else{
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
             }
    }

    public function edit($id, Request $request)
    {
        $brand = brand::find($id);

        if(empty($brand)){
            $request->session()->flash('error','Record not found.');
            return redirect()->route('brands.index');
        }
        $data['brand'] = $brand;
        return view('admin.Brands.brands_edit',$data);
    }

    public function update($id, Request $request)
    {
        $brand = brand::find($id);

        if(empty($brand)){
            $request->session()->flash('error','Record not found.');
            return redirect()->route('brands.index');
        }



        $validator = Validator::make($request->all(),[
            'name' => 'required',
            // 'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
            'slug' => 'required|unique:brands,slug'.$brand->id.',id',
         ]);

         if($validator->passes()){
            $brand = new brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            $request->session()->flash('message','Data update successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully:'
            ]);


         } else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


}
