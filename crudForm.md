## Formulario para crear un post

La forma en la que podemos crear el formulario para crear un post es resolviendo la vista en el controlador de post


```php
public function create()
{    
    $categories = Category::pluck('id','title');

    return view('dashboard/post/create',compact('categories'));
}
```

De esta forma debemo crear una vista necesaria para mostrar el formulario en la vista con lo cual quedaria de la siguiente forma


```php
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
```

De esta forma utilizamos un layout para crear el formulario que corresponde ala creacion de un post

