<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(HandlePrecognitiveRequests::class, [
            'only' => ['store', 'update'],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()
            ->filter(request()->only('search', 'status'))
            ->with('user:id,name')
            ->latest()
            ->paginate(10, ['id', 'title', 'content', 'publish', 'user_id'])
            ->withQueryString();

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'filters' => request()->only('search', 'status'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $attributes = $request->validated();
        $attributes['slug'] = Str::slug($attributes['title'], '-');
        $attributes['user_id'] = auth()->id();

        Post::create($attributes);

        return to_route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $onlyNeededPost = $post->only('title', 'content', 'publish');

        return Inertia::render('Posts/View', [
            'post' => $onlyNeededPost,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $onlyNeededPost = $post->only('id', 'title', 'content', 'publish');

        return Inertia::render('Posts/Edit', [
            'post' => $onlyNeededPost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return to_route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }
}
