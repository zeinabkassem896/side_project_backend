<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function getCategories(){
        $category = Category::all();

        foreach($category as $each){
            $each->item_categories;
        }
        $respond = [
            'status'=> 201,
            'message' => "success",
            'data' => $category
        ];
        return $respond;
    }

    public function getCategoryById($id){
        $category = Category::find($id);
        $category->item_categories;
        
        return $category;
    }

    public function createCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($validator->fails()) {
            $respond = [
                'status'=> 401,
                'message' =>  $validator->messages()->first(),
                'data' => null,
            ];

            return $respond;
        }

        $category = new Category();
        $category->name = $request->name;
        
        if ($files = $request->file('image')) {
            $destinationPath = 'image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $category->image = $profileImage;
        }

        $category->save();
        
        if(isset($request->item_id)){

            $item_array = json_decode($request->item_id, true);
            foreach($item_array as $each){
                $category->item_categories()->attach($each);
            }
        }

        $respond = [
            'status'=> 201,
            'message' => "success",
            'data' => $category
        ];

        return $respond;

    }

    public function deleteCategory($id){
        $category = Category::find($id);

        if(isset($category)){

            $category->delete();

            $respond = [
                'status'=> 201,
                'message' => "success",
                'data' => $category
            ];
        }else{
            $respond = [
                'status'=> 403,
                'message' => "Category not found"
            ];
        }


            return $respond;
        
         
    }

    public function updateCategory(Request $request, $id){

        $category = Category::find($id);
        log::info($category);
       

        if(isset($category)){

            //edit

            $category->update($request->all());
           
            if ($files = $request->file('image')) {
                $destinationPath = 'image/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
                $category->image = $profileImage;
                $category->save();
            }            

            $respond = [
                'status'=> 201,
                'message' => "success",
                'data' => $category
            ];


        }else{
            $respond = [
                'status'=> 403,
                'message' => "Category not found"
            ];
        }

        return $respond;

    }
}
