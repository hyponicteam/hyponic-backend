<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\VideoCategory;
use Illuminate\Http\Request;

class VideoCategoryController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $show_video = $request->input('show_video');

        $video_category = VideoCategory::query();

        if ($name) {
            $video_category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_video) {
            $video_category->with(['videos']);
        }

        return ResponseFormatter::success(
            $video_category->get(),
            'Get video category list success.'
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
            'image_url' => 'string|required',
            'name' => 'string|required',
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input.',
                400
            );
        }

        $video_category = VideoCategory::create([
            'image_url' => $fields['image_url'],
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            $video_category,
            'New video category created.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VideoCategory $video_category)
    {
        $video_category->load('videos');

        return ResponseFormatter::success(
            $video_category,
            'Get video category success.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VideoCategory  $video_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoCategory $video_category)
    {
        $image_url = $request->input('image_url');
        $name = $request->input('name');

        if ($image_url) {
            $fields = $request->validate(['image_url' => 'string']);
            $video_category->update([
                'image_url' => $fields['image_url']
            ]);
        }

        if ($name) {
            $fields = $request->validate(['name' => 'string']);
            $video_category->update([
                'name' => $fields['name']
            ]);
        }

        return ResponseFormatter::success(
            $video_category,
            'Video category updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VideoCategory  $video_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoCategory $video_category)
    {
        $video_category->delete();

        return ResponseFormatter::success(
            null,
            'Video category deleted.'
        );
    }
}
