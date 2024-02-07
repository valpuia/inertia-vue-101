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
            ->wherePublish(1)
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
}
