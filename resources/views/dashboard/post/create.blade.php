@extends('layouts/main')

@section('content')
    <h1>Formulario para los post</h1>
    <form action="" method="post">
        <label for="">Title</label>
        <input type="text" name="title">
        <label for="">Slug</label>
        <label for="">Category</label>
        <select name="category">
            @foreach ($categories as $title => $id)
                <option value="{{$id}}">{{$title}}</option>
            @endforeach
        </select>
        <input type="text" name="slug">
        <label for="">Description</label>
        <label for="">Posted</label>
        <select name="posted">
            <option value="yes">Yes</option>
            <option value="not">Not</option>
        </select>
        <input type="text" name="description">
        <label for="">Content</label>
        <input type="text" name="content">
        <label for="">Image</label>
        <input type="text" name="image">
        <button type="submit">Send</button>
    </form>
@endsection

@section('morecontent')
<h1>Logros</h1>
<p>Ser morgan black hand</p>
@endsection