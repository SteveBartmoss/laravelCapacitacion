@extends('layouts/main')

@section('content')

    @include('dashboard.fragment.errors-form')

    <h1>Formulario para los post</h1>
    <form action="{{ route('post.store')}}" method="post">
        @csrf
        <label for="">Title</label>
        <input type="text" name="title">
        <label for="">Slug</label>
        <input type="text" name="slug">
        <label for="">Content</label>
        <input type="text" name="content">
        <label for="">Category</label>
        <select name="category_id">
            @foreach ($categories as $title => $id)
                <option value="{{$id}}">{{$title}}</option>
            @endforeach
        </select>
        <label for="">Description</label>
        <input type="text" name="description">
        <label for="">Posted</label>
        <select name="posted">
            <option value="not">Not</option>
            <option value="yes">Yes</option>
        </select>
        <label for="">Image</label>
        <input type="text" name="image">
        <button type="submit">Send</button>
    </form>
@endsection

@section('morecontent')
<h1>Ver la lista de posts</h1>
<a href="{{route('post.index')}}">Lista post</a>
@endsection