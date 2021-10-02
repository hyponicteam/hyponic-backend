<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $id = $request->input('id');

        if ($id) {
            $article = Article::with(['articleCategory', 'user'])->find($id);

            if ($article) {
                return ResponseFormatter::success(
                    $article,
                    'Get article with ID: ' . $id . ' success.'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Article with ID: ' . $id . ' not found.',
                    404
                );
            }
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $article_category_id = $request->input('article_category_id');
        $user_id = $request->input('user_id');

        $articles = Article::with(['articleCategory', 'user']);

        if ($title) {
            $articles->where('title', 'like', '%' . $title . '%');
        }

        if ($content) {
            $articles->where('content', 'like', '%' . $content . '%');
        }

        if ($article_category_id) {
            $articles->where('article_category_id', $article_category_id);
        }

        if ($user_id) {
            $articles->where('user_id', $user_id);
        }

        $limit = $request->input('limit');

        return ResponseFormatter::success(
            $articles->paginate($limit),
            'Get article list success.'
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
        $fields = $request->validate([
            'title' => 'string|required',
            'content' => 'string|required',
            'image_url' => 'string|required',
            'article_category_id' => 'numeric|required',
            'user_id' => 'numeric|required'
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input.',
                400
            );
        }

        Article::create([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'image_url' => $fields['image_url'],
            'article_category_id' => $fields['article_category_id'],
            'user_id' => $fields['user_id']
        ]);

        return ResponseFormatter::success(
            null,
            'New article created.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');

        if(!$id) {
            return ResponseFormatter::error(
                null,
                'Error no ID given.',
                400
            );
        }

        $article = Article::find($id);

        if (!$article) {
            return ResponseFormatter::error(
                null,
                'Article with ID: ' . $id . ' not found.',
                404
            );
        }

        $title = $request->input('title');
        $content = $request->input('content');
        $image_url = $request->input('image_url');
        $article_category_id = $request->input('article_category_id');
        $user_id = $request->input('user_id');

        if ($title) {
            $fields = $request->validate(['title' => 'string']);
            $article->update([
                'title' => $fields['title']
            ]);
        }

        if ($content) {
            $fields = $request->validate(['content' => 'string']);
            $article->update([
                'content' => $fields['content']
            ]);
        }

        if ($image_url) {
            $fields = $request->validate(['image_url' => 'string']);
            $article->update([
                'image_url' => $fields['image_url']
            ]);
        }

        if ($article_category_id) {
            $fields = $request->validate(['article_category_id' => 'numeric']);
            $article->update([
                'article_category_id' => $fields['article_category_id']
            ]);
        }

        if ($user_id) {
            $fields = $request->validate(['user_id' => 'numeric']);
            $article->update([
                'user_id' => $fields['user_id']
            ]);
        }

        return ResponseFormatter::success(
            null,
            'Article with ID: ' . $id . ' updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        
        if(!$id) {
            return ResponseFormatter::error(
                null,
                'ID not given.',
                400
            );
        }

        $article = Article::find($id);
        
        if(!$article) {
            return ResponseFormatter::error(
                null,
                'Article with ID: ' . $id . ' not found.',
                404
            );
        }

        $article->delete();

        return ResponseFormatter::success(
            null,
            'Article with ID: ' . $id . ' deleted.'
        );
    }
}
