<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all posts from the database
        $posts = Post::all();

        // Return a JSON response with the posts
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate user input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new post
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        // Return a JSON response with the newly created post
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Retrieve the post by ID
         $post = Post::find($id);

         // Check if the post exists
         if (!$post) {
             return response()->json(['message' => 'Post not found'], 404);
         }
 
         // Return a JSON response with the post
         return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validate user input
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        // Check validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Update the post
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();

        // Return a JSON response with the updated post
        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
           // Find the post by ID
           $post = Post::find($id);

           // Check if the post exists
           if (!$post) {
               return response()->json(['message' => 'Post not found'], 404);
           }
   
           // Delete the post
           $post->delete();
   
           // Return a JSON response with a success message
           return response()->json(['message' => 'Post deleted successfully']);
       
    }
}
