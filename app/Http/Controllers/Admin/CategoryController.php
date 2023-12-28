<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\temp_image;
use Illuminate\Support\Facades\File;
use Image;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories = $categories->paginate(10);
        return view('admin.list',compact('categories'));///==> compact is used to send data in html page

    }
    public function create()
    {
        return view('create.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories'

        ]);
        if($validator->passes())
        {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();

            // save image here categories
                if(!empty($request->image_id)){
                    $tempImage = temp_image::find($request->image_id);
                    $extArray = expLode('.',$tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $category->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);

                    // Generate Image Thumbnail 
                    // $dPath = public_path().'/uploads/category/thumnail/'.$newImageName;
                    // $Image = Image::make($sPath);
                    // $Image->resize(450, 400);
                    // $Image->save($dPath);

                    $category->image = $newImageName;
                    $category->save();
                }

            $request->session()->flash('success','Category added Successfully');

            return response()->json([
                'status' => true,
                'message' =>'Category added Successfully'
            ]);


        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $cateid = Category::find($id);
        if(empty($id)){
            return redirect()->route('categories.index');
        }
        return view('admin.edit',compact('cateid'));
        
    }
    public function update($id, Request $request)
    {
        $cateid = Category::find($id);
        if(empty($cateid)){
            return redirect()->route('categories.index');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'.$cateid->id.',id',

        ]);
        if($validator->passes())
        {
            // $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->save();
            // $oldimage = $category->image;

            // save image here categories
                if(!empty($request->image_id)){
                    $tempImage = temp_image::find($request->image_id);
                    $extArray = expLode('.',$tempImage->name);
                    $ext = last($extArray);

                    $newImageName = $category->id.'.'.$ext;
                    $sPath = public_path().'/temp/'.$tempImage->name;
                    $dPath = public_path().'/uploads/category/'.$newImageName;
                    File::copy($sPath,$dPath);

                    // Generate Image Thumbnail 
                    // $dPath = public_path().'/uploads/category/thumnail/'.$newImageName;
                    // $Image = Image::make($sPath);
                    // $Image->resize(450, 400);
                    // $Image->save($dPath);

                    $category->image = $newImageName;
                    $category->save();
                    // File::delete(public_path().'/uploads/category/thumb/'.$oldimage);
                    // File::delete(public_path().'/uploads/category/'.$oldimage);
                }

            $request->session()->flash('success','Category updated Successfully');

            return response()->json([
                'status' => true,
                'message' =>'Category updated  Successfully'
            ]);


        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
    }
    public function distroy($id, Request $request)
    {
        $cateid = Category::find($id);
        if(empty($cateid)){
            return redirect()->route('categories.index');
        }
        // File::delete(public_path().'/uploads/category/thumb/'.$cateid->image);
        File::delete(public_path().'/uploads/category/'.$cateid->image);

        $cateid->delete();

        $request->Session->flash('success','Category Delete Successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Category Delete Successfully'
        ]);
    }
}
