<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
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
        $userId = auth()->check() ? auth()->id() : 1; //config('app.admin_user_id');

        $news = new News();
        $news->setAttribute('title', $validatedData['title']);
        $news->setAttribute('content', $validatedData['content']);
        $news->setAttribute('user_id', $userId);
        $news->save();

        return response()->json(['success' => true]);
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

        return response()->json(['success' => true]);
    }
}
