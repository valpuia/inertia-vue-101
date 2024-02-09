<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->published()
            ->with('user:id,name')
            ->latest()
            ->simplePaginate(9, [
                'user_id', 'title', 'slug', 'content',
            ]);

        if ($request->wantsJson()) {
            return $posts;
        }

        return Inertia::render('Guest/Home', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        $onlyNeededPost = $post->loadMissing('user:id,name')
            ->only('user_id', 'title', 'content', 'created_at', 'user');

        $formatDate = $post->created_at->format('dS M Y');

        return Inertia::render('Guest/PostDetail', [
            'post' => $onlyNeededPost,
            'date' => $formatDate,
        ]);
    }
}
