<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\categoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $category = categoryResource::collection(Category::all()) ;
        return response()->json([
            'data' => $category,
            'con' => true,
            'message' =>"all categories"
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'name' => 'required|max:255',
         ]);

         if ($validator->fails()) {
             return response()->json([
                 "error" => $validator->errors()
             ]);
         }else{
             $category = new Category();
             $category->name = $request->name;
             $category->slug = Str::of($request->name)->slug();
             $category->save();
             return response()->json([
                 'data' => new categoryResource($category),
                 'con' => true,
                 'message' =>"all categories"
             ],201);
         }

    }
    public function show($category)
    {
        $data = Category::where('slug' , $category)->first();
        return response()->json([
            'data' => new categoryResource($data),
            'con' => true,
            'message' =>"updated"
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$category)
    {

         $validator = Validator::make($request->all(), [
             'name' => 'required|max:255',
         ]);

         if ($validator->fails()) {
             return response()->json([
                 "error" => $validator->errors()
             ]);
         }else{
             $category = Category::where('slug',$category)->first();
             $category->name = $request->name;
             $category->slug = Str::of($request->name)->slug();
             $category->update();
             return response()->json([
                 'data' => new categoryResource($category),
                 'con' => true,
                 'message' =>"updated"
             ],200);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $category = Category::where('slug',$category)->first();
        $category->delete();
        return response()->json([
            'data' => $category,
            'con' => true,
            'message' =>"deleted"
        ],200);
    }
}
