<?php

namespace App\Http\Controllers\API;

use App\ArticleCategory;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $id = $request->input('id');

        if($id) {
            $article_category = ArticleCategory::with(['articles'])->find($id);
            
            if($article_category) {
                return ResponseFormatter::success(
                    $article_category,
                    'Get article category with ID: ' . $id . ' success.'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Article category with ID : ' . $id . ' not found.',
                    404
                );
            }
        }

        $name = $request->input('name');
        $show_article = $request->input('show_article');
        
        $article_category = ArticleCategory::query();

        if($name) {
            $article_category->where('name', 'like', '%' . $name . '%');
        }

        if($show_article) {
            $article_category->with(['articles']);
        }

        return ResponseFormatter::success(
            $article_category->get(),
            'Get article category list success.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_user = auth()->user();
        if($auth_user->role != "ADMIN") {
            return ResponseFormatter::error(
                null,
                'You\'re not an admin.',
                400
            );
        }

        $fields = $request->validate([
            'image_url' => 'string|required',
            'name' => 'string|required',
        ]);

        if(!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input.',
                400
            );
        }

        ArticleCategory::create([
            'image_url' => $fields['image_url'],
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            null,
            'New article category created.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ArticleCategory  $article_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $auth_user = auth()->user();
        if($auth_user->role != "ADMIN") {
            return ResponseFormatter::error(
                null,
                'You\'re not an admin.',
                400
            );
        }

        $id = $request->input('id');

        if(!$id) {
            return ResponseFormatter::error(
                null,
                'No ID given.',
                400
            );
        }

        $article_category = ArticleCategory::find($id);

        if (!$article_category) {
            return ResponseFormatter::error(
                null,
                'Article with ID: ' . $id . ' not found.',
                404
            );
        }

        $image_url = $request->input('image_url');
        $name = $request->input('name');
        
        if ($image_url) {
            $fields = $request->validate(['image_url' => 'string']);
            $article_category->update([
                'image_url' => $fields['image_url']
            ]);
        }

        if ($name) {
            $fields = $request->validate(['name' => 'string']);
            $article_category->update([
                'name' => $fields['name']
            ]);
        }

        return ResponseFormatter::success(
            null,
            'Article category with ID: ' . $id . ' updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ArticleCategory  $article_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $auth_user = auth()->user();
        if($auth_user->role != "ADMIN") {
            return ResponseFormatter::error(
                null,
                'You\'re not an admin.',
                400
            );
        }

        $id = $request->input('id');
        
        if(!$id) {
            return ResponseFormatter::error(
                null,
                'No ID given.',
                400
            );
        }

        $article_category = ArticleCategory::find($id);
        
        if(!$article_category) {
            return ResponseFormatter::error(
                null,
                'Article category with ID: ' . $id . ' not found.',
                404
            );
        }

        $article_category->delete();

        return ResponseFormatter::success(
            null,
            'Article category with ID: ' . $id . ' deleted.'
        );
    }
}
