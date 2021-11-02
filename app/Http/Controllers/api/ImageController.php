<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
    }

    public function upload(Request $request)
    {
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $image = $request->file('images');
                $filename = time().rand(3, 2). '.'.$image->getClientOriginalExtension();
           
                $image->move('uploads/', $filename);

                Image::create([
                    'image_name' => $filename
                ]);
            }
            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        } else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }

        return response()->json($response);
       
        /*   $imagesName = [];
           $response = [];

           $validator = Validator::make(
               [
                   'images' => 'required',
                   'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
               ]
           );

           if ($validator->fails()) {
               return response()->json(["status" => "failed", "message" => "Validation error", "errors" => $validator->errors()]);
           }
           if ($request->has('images')) {
               foreach ($request->file('images') as $image) {
                   $filename = time().rand(3). '.'.$image->getClientOriginalExtension();
                   $image->move('uploads/', $filename);

                   Image::create([
                       'image_name' => $filename
                   ]);
               }

               $response["status"] = "successs";
               $response["message"] = "Success! image(s) uploaded";
           } else {
               $response["status"] = "failed";
               $response["message"] = "Failed! image(s) not uploaded";
           }
           return response()->json($response); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
