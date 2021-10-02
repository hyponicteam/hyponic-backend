<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\VideoCategory;
use Illuminate\Http\Request;

class VideoCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');

        if($id) {
            $video_category = VideoCategory::with(['videos'])->find($id);
            
            if($video_category) {
                return ResponseFormatter::success(
                    $video_category,
                    'Get video category with ID: ' . $id . ' success.'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Video category with ID: ' . $id . ' not found.',
                    404
                );
            }
        }

        $name = $request->input('name');
        $show_video = $request->input('show_video');
        
        $video_category = VideoCategory::query();

        if($name) {
            $video_category->where('name', 'like', '%' . $name . '%');
        }

        if($show_video) {
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

        if(!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input.',
                400
            );
        }

        VideoCategory::create([
            'image_url' => $fields['image_url'],
            'name' => $fields['name']
        ]);

        return ResponseFormatter::success(
            null,
            'New video category created.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VideoCategory  $video_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');

        if(!$id) {
            return ResponseFormatter::error(
                null,
                'No ID given.',
                400
            );
        }

        $video_category = VideoCategory::find($id);

        if (!$video_category) {
            return ResponseFormatter::error(
                null,
                'Video category with ID: ' . $id . ' not found.',
                404
            );
        }

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
            null,
            'Video category with ID: ' . $id . ' updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VideoCategory  $video_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        
        if(!$id) {
            return ResponseFormatter::error(
                null,
                'No ID given.',
                400
            );
        }

        $video_category = VideoCategory::find($id);
        
        if(!$video_category) {
            return ResponseFormatter::error(
                null,
                'Video category with ID: ' . $id . ' not found.',
                404
            );
        }

        $video_category->delete();

        return ResponseFormatter::success(
            null,
            'Video category with ID: ' . $id . ' deleted.'
        );
    }
}
