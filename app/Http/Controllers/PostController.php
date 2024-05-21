<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(Request $request)
    { 
        $user = Auth::user();
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id'=>['required','integer','exists:categories,id'],      
        ]);
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => $user->id, 
        ]);
        if($post){
        return response()->json([
            'status' => 'success',
            'message' => 'post created successfully',
            'post' => $post,
           
        ]);
    }
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json([
            'status' => 'success',
            'post' => $post,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',      
        ]);
        $post = Post::find($id);
        $user = Auth::user();
        if($request->user()->id === $post->user_id){
            $post->title = $request->title;
            $post->body = $request->body;
            $post->category_id = $request->category_id;
            $post->save();
            return response()->json($post, 200);
        }  
        else{
            return "you can't update this post";
        } 
    }
    
    public function destroy(Request $request,$id)
    { 
        $post = Post::find($id);
        $user = Auth::user();
        if($request->user()->id === $post->user_id){
        $post->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'post deleted successfully',
            ]);
        } 
        else{
            return response()->json([
                'status' => 'not success',
                'message' => 'you cannot delete this post',                
            ]);
        }
        }
}
