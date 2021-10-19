<?php

namespace App\Http\Controllers;

use App\VideoCategory;
use Illuminate\Http\Request;

class WebVideoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = VideoCategory::with(['videos'])->get();
        return view('admin.video_category.index', [
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
        return view('admin.video_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        VideoCategory::create([
            'name' => request('name'),
            'image_url' => request('image_url')
        ]);
        
        return redirect('/video-categories')->with('success', 'New category created.');
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
        return view('admin.video_category.detail', [
            'category' => $video_category
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(VideoCategory $video_category)
    {
        return view('admin.video_category.edit', [
            'category' => $video_category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoCategory $video_category)
    {
        $video_category->update([
            'name' => request('name'),
            'image_url' => request('image_url')
        ]);

        return redirect('/video-categories')->with('success', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VideoCategory $video_category)
    {
        $video_category->delete();

        return redirect('/video-categories')->with('success', 'Category has been deleted.');
    }
}
