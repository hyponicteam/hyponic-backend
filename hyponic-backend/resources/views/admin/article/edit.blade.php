@extends('layouts.master')

@section('title')
    <title>Edit Article</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Edit Article</h1>
                <form action="/articles/{{ $article['id'] }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $article['title'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <input type="text" class="form-control" id="content" name="content" value="{{ $article['content'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <small class="text-muted">Kalo mo pake gambar sendiri, bisa upload dulu di imgur atau
                            picc.io</small>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="{{ $article['image_url'] }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category ID</label><br />
                        <input type="text" class="form-control" id="category" name="article_category_id" value="{{ $article['article_category_id'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection