<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class WebArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['user'])->get();
        return view('admin.article.index', [
            'articles' => $articles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Article::create([
            'title' => request('title'),
            'content' => request('content'),
            'image_url' => request('image_url'),
            'article_category_id' => request('article_category_id'),
            'user_id' => 1
        ]);
        
        return redirect('/articles')->with('success', 'New article created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load('user', 'articleCategory');
        return view('admin.article.detail', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.article.edit', [
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update([
            'title' => request('title'),
            'content' => request('content'),
            'image_url' => request('image_url'),
            'article_category_id' => request('article_category_id'),
            'user_id' => 1
        ]);

        return redirect('/articles')->with('success', 'Article has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect('/articles')->with('success', 'Article has been deleted.');
    }
}