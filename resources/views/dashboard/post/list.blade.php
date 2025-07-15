@extends('layouts/main')

@section('content')
    <h1>Lista de post creados</h1>

    <h1>Puedes crear un post en el siguiente enlace</h1>
    <a href="{{route('post.create')}}">Crear post</a>

    <table>
        <thead>
            <tr>
                <td>
                    id
                </td>
                <td>
                    Title
                </td>
                <td>
                    Posted
                </td>
                <td>
                    Category
                </td>
                <td>
                    options
                </td>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($postList as $key => $value)
            <tr>
                <td>
                    {{ $value->id }}
                </td>
                <td>
                    {{$value->title}}
                </td>
                <td>
                    {{$value->posted}}
                </td>
                <td>
                    {{$value->category->title}}
                </td>
                <td>
                    <a href="{{route('post.edit',$value->id)}}">Editar</a>
                    <a href="{{route('post.show',$value->id)}}">ver</a>
                    <a href="{{route('post.destroy',$value->id)}}">Eliminar</a>
                </td>
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