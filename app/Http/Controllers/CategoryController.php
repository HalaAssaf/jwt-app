<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index()
    {
        $category = Category::get();
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',            
        ]);
        $category = Category::create([
            'name' => $request->name,
        ]);
        if($category){
        return response()->json([
            'status' => 'success',
            'message' => 'category created successfully',
            'category' => $category,
        ]);
    }
    }

    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'status' => 'success',
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',       
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        if($category){
             return response()->json([
            'status' => 'success',
            'message' => 'category updated successfully',
            'category' => $category,
        ]);
    }
    if(!$category){
        return response()->json([
       'status' => 'not success',
   ]);
    }}
    public function destroy($id)
    {
        $category = category::find($id);
        if(!$category){
            return "this category is not found";
        }
        $category->delete($id);
        if($category)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'category deleted successfully',
                
            ]);
        } 
        }   
    }


