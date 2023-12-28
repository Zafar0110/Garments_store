<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\temp_image;

class TemImageController extends Controller
{
    //
    public function create(Request $request)
    {
        $image = $request->image;

        if(!empty($image)){
            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage = new temp_image();
            $tempImage->name = $newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            return response()->json
            ([
                'status' => true,
                'image_id' => $tempImage->id,
                'message' => 'image uploaded successfully'
            ]);

        }
    }
}
