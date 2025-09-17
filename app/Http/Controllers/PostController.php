<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::latest()->filter($request->only(['search', 'category', 'author']))->get();

        // Tambahkan highlight jika ada pencarian
        $posts->transform(function ($post) use ($search) {
            if ($search) {
                $post->highlighted_title = preg_replace("/($search)/i", '<mark>$1</mark>', $post->title);
                $post->highlighted_body  = preg_replace("/($search)/i", '<mark>$1</mark>', Str::limit($post->body, 100));
            } else {
                $post->highlighted_title = $post->title;
                $post->highlighted_body  = Str::limit($post->body, 100);
            }
            return $post;
        });

        return view('posts', [
            'title' => 'All Posts',
            'posts' => $posts,
        ]);
    }
}
