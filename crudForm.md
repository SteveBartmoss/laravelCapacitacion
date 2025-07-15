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