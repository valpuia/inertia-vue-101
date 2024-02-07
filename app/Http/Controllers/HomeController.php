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
            ->simplePaginate(6, [
                'user_id', 'title', 'slug', 'content',
            ]);

        if ($request->wantsJson()) {
            return $posts;
        }

        return Inertia::render('Guest/Home', [
            'posts' => $posts,
        ]);
    }

    public function show($slug)
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->with('user:id,name')
            ->select('user_id', 'title', 'content', 'created_at')
            ->firstOrFail();

        $formatDate = $post->created_at->format('dS M Y');

        return Inertia::render('Guest/PostDetail', [
            'post' => $post,
            'date' => $formatDate,
        ]);
    }
}
