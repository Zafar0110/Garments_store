<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\sub_categorie;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        $sub_categories = sub_categorie::select('sub_categories.*','categories.name as categoryName')
                                  ->latest('sub_categories.id')
                                  ->leftjoin('categories','categories.id','sub_categories.category_id');

        if(!empty($request->get('keyword'))){
            $sub_categories = $sub_categories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
            $sub_categories = $sub_categories->orwhere('categories.name','like','%'.$request->get('keyword').'%');

         }

        $sub_categories = $sub_categories->paginate(10);
        return view('admin.sub_category.sub_list',compact('sub_categories'));///==> compact is used to send data in html page

    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create',$data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()){

            $subCategory = new sub_categorie();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success','Sub Category created Successfully:');


            return response([
                'status' => true,
                'message' => 'Sub Category created Successfully'
            ]);




        } else{
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $subcategory = sub_categorie::find($id);
        if(empty($subcategory)){
            $request->session()->flash('error', 'Records not found');
            return redirect()->route('sub-categories.index');
        }

        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subcategory'] = $subcategory;
        return view('admin.sub_category.edit',$data);
    }
    public function update($id, Request $request)
    {
        $subcategory = sub_categorie::find($id);

        if(empty($subcategory)){
            $request->session()->flash('error', 'Records not found');
            return redirect()->route('sub-categories.index');
        }


        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required'
        ]);
        if ($validator->passes()){

            // $subCategory = new sub_categorie();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success','Sub Category updated Successfully:');


            return response([
                'status' => true,
                'message' => 'Sub Category created Successfully'
            ]);




        } else{
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id, Request $request)
    {
        $subcategory = sub_categorie::find($id);

        if(empty($subcategory)){
            $request->session()->flash('error', 'Records not found');
            return redirect()->route('sub-categories.index');
        }
        $subcategory->delete();
        $request->session()->flash('success','Sub Category delete Successfully:');


            return response([
                'status' => true,
                'message' => 'Sub Category delete Successfully'
            ]);
        

    }
}
