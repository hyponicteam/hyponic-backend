<?php

namespace App\Http\Controllers;

use App\ArticleCategory;
use Illuminate\Http\Request;

class WebArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ArticleCategory::with(['articles'])->get();
        return view('admin.article_category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ArticleCategory::create([
            'name' => request('name'),
            'image_url' => request('image_url')
        ]);
        
        return redirect('/article-categories')->with('success', 'New category created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $article_category)
    {
        $article_category->load('articles');
        return view('admin.article_category.detail', [
            'category' => $article_category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $article_category)
    {
        return view('admin.article_category.edit', [
            'category' => $article_category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleCategory $article_category)
    {
        $article_category->update([
            'name' => request('name'),
            'image_url' => request('image_url')
        ]);

        return redirect('/article-categories')->with('success', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $article_category)
    {
        $article_category->delete();

        return redirect('/article-categories')->with('success', 'Category has been deleted.');
    }
}
