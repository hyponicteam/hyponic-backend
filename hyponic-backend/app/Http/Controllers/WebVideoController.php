<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class WebVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::with(['user'])->get();
        return view('admin.video.index', [
            'videos' => $videos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Video::create([
            'title' => request('title'),
            'video_url' => request('video_url'),
            'video_category_id' => request('video_category_id'),
            'user_id' => 1
        ]);
        
        return redirect('/videos')->with('success', 'New video created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $video->load('user', 'videoCategory');
        return view('admin.video.detail', [
            'video' => $video
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.edit', [
            'video' => $video
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $video->update([
            'title' => request('title'),
            'video_url' => request('video_url'),
            'video_category_id' => request('video_category_id'),
            'user_id' => 1
        ]);

        return redirect('/videos')->with('success', 'Video has been updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return redirect('/videos')->with('success', 'Video has been deleted.');
    }
}
