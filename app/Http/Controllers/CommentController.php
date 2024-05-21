<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index($postId)
    {
        $comments = Comment::where('post_id', $postId)->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    { 
        $user = Auth::user();
        $request->validate([
            'body' => 'required',
            'post_id' => 'required|exists:posts,id',           
        ]);
        $comment = comment::create([
            'body' => $request->body,
            'post_id' => $request->post_id,
            'user_id' => $user->id,
        ]);
        if($comment){
        return response()->json([
            'status' => 'success',
            'message' => 'comment created successfully',
            'comment' => $comment,
        ]);
    }
    }

    public function show($id)
    {
        $comment = comment::find($id);
        return response()->json([
            'status' => 'success',
            'comment' => $comment,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'content' => 'sometimes|required|max:255',
            'post_id' => 'sometimes|required|exists:posts,id',
        ]);
        $user = Auth::user();
        $comment = Comment::find($id);
        if($request->user()->id === $comment->user_id){
            $comment = Comment::findOrFail($id);
            $comment->update($request->all());
            return response()->json($comment, 200);
        }
        else{
            return "you can't update this comment";
        }  
         }
    
    public function destroy(Request $request,$id)
    {
        $user = Auth::user();
        $comment = Comment::find($id);
        if($request->user()->id === $comment->user_id){
            return response()->json([
                'status' => 'success',
                'message' => 'comment deleted successfully',
            ]);
        }
        else{
            return response()->json([
                'status' => 'not success',
                'message' => 'you cannot delete this comment',            
            ]);
        }
        $comment->delete($id);
       
        } 
        }

