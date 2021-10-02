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
            $articleCategory = ArticleCategory::with(['articles'])->find($id);
            
            if($articleCategory) {
                return ResponseFormatter::success(
                    $articleCategory,
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
        $showArticle = $request->input('showArticle');
        
        $articleCategory = ArticleCategory::query();

        if($name) {
            $articleCategory->where('name', 'like', '%' . $name . '%');
        }

        if($showArticle) {
            $articleCategory->with(['articles']);
        }

        $limit = $request->input('limit');

        return ResponseFormatter::success(
            $articleCategory->get(),
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
        $authUser = auth()->user();
        if($authUser->role != "ADMIN") {
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
     * @param  \App\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $authUser = auth()->user();
        if($authUser->role != "ADMIN") {
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

        $articleCategory = ArticleCategory::find($id);

        if (!$articleCategory) {
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
            $articleCategory->update([
                'image_url' => $fields['image_url']
            ]);
        }

        if ($name) {
            $fields = $request->validate(['name' => 'string']);
            $articleCategory->update([
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
     * @param  \App\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $authUser = auth()->user();
        if($authUser->role != "ADMIN") {
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

        $articleCategory = ArticleCategory::find($id);
        
        if(!$articleCategory) {
            return ResponseFormatter::error(
                null,
                'Article category with ID: ' . $id . ' not found.',
                404
            );
        }

        $articleCategory->delete();

        return ResponseFormatter::success(
            null,
            'Article category with ID: ' . $id . ' deleted.'
        );
    }
}

