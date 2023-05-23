<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    public function index()
    {
        $category = CategoryResource::collection(Category::all()) ;
        return $this->success($category);
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
            return $this->fail($validator->errors());
         }else{
             $category = new Category();
             $category->name = $request->name;
             $category->slug = Str::of($request->name)->slug();
             $category->save();
           return $this->success(new CategoryResource($category),"success");
         }
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
             return $this->fail($validator->errors());
         }else{
             $category = Category::where('slug',$category)->first();
             $category->name = $request->name;
             $category->slug = Str::of($request->name)->slug();
             $category->update();
            return $this->success(new CategoryResource($category),"updated");
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
        return $this->response("deleted",$category,[]);
    }
}
