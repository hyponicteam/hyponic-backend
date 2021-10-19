<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $video_category_id = $request->input('video_category_id');

        $videos = Video::with(['videoCategory']);

        if ($title) {
            $videos->where('title', 'like', '%' . $title . '%');
        }

        if ($video_category_id) {
            $videos->where('video_category_id', $video_category_id);
        }

        $limit = $request->input('limit');

        return ResponseFormatter::success(
            $videos->get(),
            'Get video list success.'
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
            'video_url' => 'string|required',
            'video_category_id' => 'numeric|required',
            'user_id' => 'numeric|required'
        ]);

        if (!$fields) {
            return ResponseFormatter::error(
                null,
                'Invalid input.',
                400
            );
        }

        $video = Video::create([
            'title' => $fields['title'],
            'video_url' => $fields['video_url'],
            'video_category_id' => $fields['video_category_id'],
            'user_id' => $fields['user_id'],
        ]);

        return ResponseFormatter::success(
            $video,
            'New video created.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $video->load('videoCategory', 'user');

        return ResponseFormatter::success(
            $video,
            'Get video success.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $title = $request->input('title');
        $video_url = $request->input('video_url');
        $video_category_id = $request->input('video_category_id');
        $user_id = $request->input('user_id');

        if ($title) {
            $fields = $request->validate(['title' => 'string']);
            $video->update([
                'title' => $fields['title']
            ]);
        }

        if ($video_url) {
            $fields = $request->validate(['video_url' => 'string']);
            $video->update([
                'video_url' => $fields['video_url']
            ]);
        }

        if ($video_category_id) {
            $fields = $request->validate(['video_category_id' => 'string']);
            $video->update([
                'video_category_id' => $fields['video_category_id']
            ]);
        }

        if ($user_id) {
            $fields = $request->validate(['user_id' => 'string']);
            $video->update([
                'user_id' => $fields['user_id']
            ]);
        }

        return ResponseFormatter::success(
            $video,
            'Video updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return ResponseFormatter::success(
            null,
            'Video deleted.'
        );
    }
}
