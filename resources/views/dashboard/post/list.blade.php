@extends('layouts/main')

@section('content')
    <h1>Lista de post creados</h1>

    @foreach ($postList as $key => $value)
        <p>
            <span>{{$value->tile}}</span>
            <span>{{$value->slug}}</span>
            <span>{{$value->description}}</span>
            <span>{{$value->content}}</span>
        </p>
    @endforeach
    
@endsection


@section('morecontent')
<h1>Puedes crear un post en el siguiente enlace</h1>
<a href="{{route('post.create')}}">Crear post</a>
@endsection