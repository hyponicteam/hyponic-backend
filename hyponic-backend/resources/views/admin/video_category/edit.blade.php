@extends('layouts.master')

@section('title')
    <title>Edit Video Category</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Edit Video Category</h1>
                <form action="/video-categories/{{ $category['id'] }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category['name'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <small class="text-muted">Kalo mo pake gambar sendiri, bisa upload dulu di imgur atau
                            picc.io</small>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ $category['image_url'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection