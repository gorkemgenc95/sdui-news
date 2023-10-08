<?php

namespace App\Http\Controllers;

use App\Events\NewsCreated;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $news = News::query()->forPage(max(1, $page))->get();
        return response()->json($news);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::query()->findOrFail($id);
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $news = new News();
        $news->setAttribute('title', $validatedData['title']);
        $news->setAttribute('content', $validatedData['content']);
        $news->user()->associate($request->user());
        $news->save();

        event(new NewsCreated($news));

        return response()->json(['success' => true], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $news = News::query()->findOrFail($id);
        $news->setAttribute('title', $validatedData['title']);
        $news->setAttribute('content', $validatedData['content']);
        $news->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::query()->findOrFail($id);
        $news->delete();

        return response()->json(['success' => true], 204);
    }
}
