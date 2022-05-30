<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Validator;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
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
            'title' => 'required|string|max:256',
            'body' => 'required',
            'author_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $post = Post::create($request->all());
        return response()->json([
            'message' => 'post created successfully',
            'user' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $updated = $post->fill($request->all())->save();
        return response()->json([
            'post' => $updated,
            'message' => 'post updated successfully'
        ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['message' => 'user deleted successfully'], 200);
    }

    public function search($title)
    {
        return Post::where('title','like', '%'.$title.'%')->get();
    }

    /**
     * Display the specified author 
     * 
     * @param int $post_id
     * @return author details
     */
    public function getAuthor($post_id)
    {
      return Post::findOrFail($post_id)->author;
    }
}
