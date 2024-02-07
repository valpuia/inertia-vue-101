<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->wherePublish(1)
            ->with('user:id,name')
            ->latest()
            ->simplePaginate(10, [
                'user_id', 'title', 'slug', 'content',
            ]);

        return Inertia::render('Guest/Home', [
            'posts' => $posts,
        ]);
    }
}
