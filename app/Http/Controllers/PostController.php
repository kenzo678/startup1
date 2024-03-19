<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost(Request $req) {
        $incomingFields = $req->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        Post::create($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post) {
        //use policy or middleware to 
        //protect this view from unauthorized users
        //for a better, safer method
        if(auth()->user()->id == $post['user_id']){
            return view('edit-post', ['post'=> $post]);
        } else {
            return redirect('/');
        }
    }

    public function editThePost(Post $post, Request $req) {
        if(auth()->user()->id !== $post['user_id']){
        return redirect('/');
        } else {

        $incomingFields = $req->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);
        return redirect('/');

        }
    }

    public function deletePost(Post $post) {
        if(auth()->user()->id !== $post['user_id']){
            return redirect('/');
        } else {
            $post->delete();
            return redirect('/');
        }
    }
}
