@extends('layouts.master')

@push('stylesheet')
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/table.css">
@endpush

@section('title')
    <title>Article Categories</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mt-4">Article Categories</h1>
                <a href="/article-categories/create" class="btn btn-success">Create New Data</a>
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                        <strong>Success! </strong> {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <table class="table table-borderless">
                    <thead>
                        <tr class="text-center">
                            <th class="fit" scope="col">Name</th>
                            <th class="fit" scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="fit"><a
                                        href="/article-categories/{{ $category['id'] }}">{{ $category['name'] }}</a>
                                </td>
                                <td class="fit"><a href="/article-categories/{{ $category['id'] }}/edit"
                                        class="btn btn-sm btn-primary table-button">Edit</a></td>
                                <td class="fit">
                                    <form action="/article-categories/{{ $category['id'] }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger table-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
