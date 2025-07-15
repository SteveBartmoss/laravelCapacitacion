@extends('layouts/main')

@section('content')
    <h1>Lista de post creados</h1>

    <table>
        <thead>
            <tr>Title</tr>
            <tr>Posted</tr>
            <tr>Category</tr>
        </thead>
        <tbody>
            @foreach ($postList as $key => $value)
            <tr>
                <td>
                    {{$value->title}}
                </td>
                <td>
                    {{$value->posted}}
                </td>
                <td>{{$value->category->title}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

    {{$postList->links() }}
    
@endsection


@section('morecontent')
<h1>Puedes crear un post en el siguiente enlace</h1>
<a href="{{route('post.create')}}">Crear post</a>
@endsection