## Formulario para crear un post

La forma en la que podemos crear el formulario para crear un post es resolviendo la vista en el controlador de post


```php
public function create()
{    
    $categories = Category::pluck('id','title');

    return view('dashboard/post/create',compact('categories'));
}
```

De esta forma debemos crear una vista necesaria para mostrar el formulario en la vista con lo cual quedaria de la siguiente forma


```php
@extends('layouts/main')

@section('content')
    <h1>Formulario para los post</h1>
    <form action="" method="post">
        <label for="">Title</label>
        <input type="text" name="title">
        <label for="">Slug</label>
        <input type="text" name="slug">
        <label for="">Content</label>
        <input type="text" name="content">
        <label for="">Category</label>
        <select name="category">
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
<h1>Logros</h1>
<p>Ser morgan black hand</p>
@endsection
```

De esta forma utilizamos un layout para crear el formulario que corresponde ala creacion de un post

## Controlador create

Como uno de los datos que mostramos en el formulario proviene de la base de datos, lo recuperamos desde la base de datos con la siguiente linea de codigo

```php
$categories = Category::pluck('id','title');
```

Pluck es un metodo de coleccion y consulta que se utiliza para extraer la lista de valores de una columna especifica de la base de datos o de una coleccion.

De esta forma creamos un arreglo de clave valor, que es muy util para asiganarla a las listas desplegables, en formularios como es el caso del formulario anterior con la lista de categorias

## Conectar el formulario para la creacion

Con el formulario creado podemos conectar lo a una funcion de creacion para que podamos guardar la informacion en la base de datos, esto lo realizamos de la siguiente manera

```php
<form action="{{ route('post.store')}}" method="post">
</form>
```

Con lo anterior estamos pasando la ruta del post.store, en caso de no recordar la ruta o no saber cual es la ruta que se definio, podemos usar el comando 


```bash
php artisan route:list
```

Esto nos mostrara las rutas, cuando ya tenemos configurada la ruta, nos macara un error al intertar acceder, ya que laravel tiene una capa de seguridad para que un formulario que no esta autenticado por laravel, no pueda mandar o acceder a ciertas rutas, por esta razon debemos hacer lo siguiente


```php
<form action="{{ route('post.store')}}" method="post">
    @csrf
</form>
```

Esto genera internamente un input oculto con un token que indica a laravel que esl formulario es valido, con esto deja de aparecer el error 4219. **Importante** se debe usar la directiva `@csrf` dentro del formulario para que surta efecto

### Guardado en base de datos

Como el formulario que creamos es personalizado, cada campo del fomulario se liga con su nombre y se envia por url a la ruta que antes configuramos, asi que para crear el post en base de datos podemos simplemente hacer lo siguiente 

```php
public function store(Request $request)
    {
        Post::create([
            'title' => $request->all()['title'],
            'slug' => $request->all()['slug'],
            'content' => $request->all()['content'],
            'category_id' => $request->all()['category_id'],
            'description' => $request->all()['description'],
            'posted' => $request->all()['posted'],
            'image' => $request->all()['image'],
        ]);
    }
```

Se puede enviar los datos en espefecico para la creacion, esto ayuda cuando tenemos datos que no pertenecen al modelo y queremos pasar solo los que necesita, en este caso como el pormulario es solo para el post podemos hacer lo siguiente

```php
public function store(Request $request)
    {
        Post::create($request->all());
    }
```

De esta forma simplemente pasamos toda la informacion y el modelo hace la relacion interna para cada valor, **Importante** esto lo hace en automatico porque laravel asume que el nombre del modelo, coincide con el nombre en el arreglo del request, pero si esto no es asi entonces la relacion no se hace en automatico y tenemos que indicar los campos como se muestra en la primera opcion


## Validacion de datos

Las validaciones de los datos que recibe una ruta tiene la siguiente forma base

```php
"title" => "required|min:5|max:500",
```

Con lo anterior podemos definir las validaciones dentro del controlador de la siguiente manera 


```php
public function store(Request $request)
    {

        $request->validate([
            'tile' => 'required|min:5|max:500',
            'slug' => 'required|min:5|max:500',
            'content' => 'required|min:7',
            'category_id' => 'required|integer',
            'description' => 'required|min:7',
            'posted' => 'required',
        ]);

    }
```

Con esta forma definimos directamente en el controlador del post las reglas de cada valor que ingrega y en caso de que este incorrecto algun dato, se redirecciona al mismo formulario de creacion

### Validacion con formRequest

Otra forma de validar los valores que mandamos a una ruta es con un form request, para esto creamos el request con el siguiente comando

```bash
php artisan make:request nombreDelRequest
```

Dentro del archivo que se segenera debemos hacer la siguiente configuracion

```php
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tile' => 'required|min:5|max:500',
            'slug' => 'required|min:5|max:500',
            'content' => 'required|min:7',
            'category_id' => 'required|integer',
            'description' => 'required|min:7',
            'posted' => 'required',
        ];
    }
}
```

En esta configuracion se puede resaltar que la funcion `authorize()` esta destinada para casos en los que un usuario no esta autorizado por el rol que tiene o aguna restriccion de validacion, en este caso no necesitamos eso por eso se cambia directamente a true

Por otra parte en la funcion `rules()` Se definen las mismas reglas que ya teniamos en la validacion previa, solo que de esta forma tenemos definidas las reglas en un archivo general y evitamos repetir el codigo entre diferentes secciones del codigo

### Insertar el request en el controlador

Cuando ya tenemos configurado  el request, simplemente tenemos que insertar el mismo request en la clase del controlador

```php
use App\Http\Requests\Post\StoreRequest;

class PostController extends Controller
{

    public function store(StoreRequest $request)
    {
        Post::create($request->all());
        return redirect()->route('post.create');
    }
}
```

Con la anterior ya tenemos cubierta la excepcion y gracias a esto el controlador queda mas simple y no tan lleno de informacion

## Mostrar errores de validacion

Caundo se trabaja con el formRequest, podemos acceder a los errores de validacion desde la variable `$errors` que laravel maneja de forma interna, de esta forma podemos mostrar simplemente los errores de la siguiente forma

```php
@section('content')

    @if($errors->any())
        @foreach ($errors->all() as $e){
            <div>
                {{ $e }}
            </div>
        }
        @endforeach
    @endif

@endsection
```

## Validar datos unicos

Cuando registramo informacion en base de datos, debemos asegurarnos que algunos cmapos sean unicos, esto es porque no queremos que un campo que se usara para buscar un solo registro este guardado mas de una vez, para evitar eso podemos usar la siguiente configuracion en el formRequest

```php
'slug' => 'required|min:5|max:500|unique:posts',
```

En la anterior configuracion estamos definiendo que este valor debe ser unico para la tabla post, de esta maner laravel internamente maneja la exception cuando encuenta el valor repetido

## Fragmento de vista

Podemos definir fragmentos para reutilizar codigo en las vistas, por ejemplo se puede reutilizar el fragmento de codigo que usamos para mostrar los errores en el formulario de la siguiente manera

```php
@if($errors->any())
    @foreach ($errors->all() as $e){
        <div>
            {{ $e }}
        </div>
    }
    @endforeach
@endif
```

De esta forma tenemos la ruta `dashboard/fragment/errors-form.blade` en donde creamos el archivo con el codigo anterior, ahora podemos insertarlo en donde lo necesitamos facilcilmente como se muestra a continuacion

```php
@section('content')

    @include('dashboard.fragment.errors-form')

@endsection
```

De esta forma estamos insertando el fragmento en el archivo `create.blade` para poder reutilizar codigo en alguna otra parte del proyecto

## Paginate

Cuando estamos listando recursos, es comun que no queremos mostrar todos los recuros en la pagina principal, ya que es dificil para los usuario ver la informacion asi que una buena opcion es usar `paginate` para que nos devuelva la informacion paginada y no tengamo que mostrar todo de una sola vez, como se muestra acontinuacion se implementa la funcion para la paginacion de la informacion desde el modelo de base de datos

```php
$postList = Post::paginate(2);
```

Con lo anterior ya tenemos la paginacion en los elemento que nos trae la base de datos pero aun debemos manejar la pagina del lado de la vista y eso es simple si usamos la siguiente funcion en el archivo `list.blade`

```php
@section('content')
    <h1>Lista de post creados</h1>

    <table>
        ...
    </table>
    

    {{$postList->links() }}
    
@endsection
```

De esta forma ya se resuelve una funcion que agrega una paginacion para mostrar los elementos respondidos desde el backend

## Actualizacion de un post 

Para actualizar la informacion que ya insertamos en la base de datos, podemos usar la vista donde mostramos todos los post que tenemos creados en base de datos, para poder mostrar en ese mismo apartado los enlaces para modificar

```php
@section('content')
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
@endsection
```

En esta tabla que mostramos podemos agregar las etiquetas a para redirigir al usuario a la pagina de editar po ejemplo, en el controlador tenemos que regresar una vista igual que como hacemos con la vista de crear, asi que se confiugura de la siguiente manera

```php
public function edit(string $id)
{
    $post = Post::find($id); 
    $categories = Category::pluck('id','title');

    return view('dashboard/post/edit',compact('post','categories'));
}
```

Como esta ruta se trata de actualizar, cuando creamos la ruta con el resource esperamos un id, porque tenemos que buscar la informacion del elemento a modificar y por eso realizamos la busqueda del post con `find` y tambien pasamos las `categories ` porque son necesarias el formulario. 

La vista que creamos para la actualizacion es exactamente igual que la vista de creacion con la diferencia de que el form cambia de ruta y ademas se tiene que decorar pues por defecto los formularios de html no soportan put,pach o delete y por esa razon usamos el decorador de `@method("PATCH")` que hace posible que se mande el metodo patch, put o delete, ademas de que los imputs ahora tienen el valor del post que mandamos

```php
<form action="{{ route('post.update', $post->id)}}" method='post'>
        @method("PATCH")
        @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{$post->title}}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            ...

        </div>
    </div>
</form>
```

De esta forma tenemos configurada la vista, podria hacerse una modificacion para que el codigo funcione la misma vista para crear y edtitar, mediante el uso de condificiones para la declaracion de los decoradores y las rutas de los formularios pero en el curso simplemente copio y pego XD

Cuando tenemos configurada la vista, debemos condfigurar la ruta que nos realice la modificacion del recurso en base de datos como se muestra a continuacion

```php
public function update(Request $request, string $id)
{
    $post = Post::find($id);
    $post->update($request->all());
    return to_route('post.index');

}
```

### Request validate para actualizar

Las reglas que se configuraron para la validacion de crear no simpre se pueden reutilizar, porque en este caso el slug lo definimos como unico pero al momento de actualizar no es necesario que sea unico, por esto debemo crear un nuevo request para la actualizacion, con el comando `php artisan make:request Post/PutRequest` la estructura quedaria de la siguiente forma 

```php
public function rules(): array
{
    return [
        'title' => 'required|min:5|max:500',
        'slug' => 'required|min:3|max:500',
        'content' => 'required|min:7',
        'category_id' => 'required|integer',
        'description' => 'required|min:7',
        'posted' => 'required',
    ];
}
```

Con esto podemos validar los campos pero el atributo slug en teoria no debe modificarse asi que podemos usar el decorador `@readonly(true)` para hacer que el imput  no este disponible para editar el campo

```php
<input  type="text" name="slug" value="{{$post->slug}}" @readonly(true)/>
```
