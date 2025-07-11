# Migraciones 

Una migracion es la forma en que laravel trabja con la base de datos de la aplicacion en la que estamos trabajando, una migracion tiene el siguiente aspecto

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

En la seccion de codigo podemos observar diferentes puntos importantes como por ejemplo `Schema::create('users', function (Blueprint $table)` en esta seccion damos nombre a la tabla que en este caso sera **users** y despues pasamos la funcion que crea la tabla lo cual indicamod en el `Blueprint $table`

La funcion que pasamos tiene como cuerpo la definicion de la estructura de la tabla que sera traducida a la base de datos, de esta forma definimos las columnas de la tabla usando el objeto `$table` y de esta forma asignamos el tipo de campo, el nombre o alguna otra propiedad para la columna, `$table->string('email')->unique();` como se puede ver se hace una especie de cadena entre funcions que indican el tipo de dato y en este caso que la informacion debe ser unica. 

Como suele ser habitual laravel nos proporciona un comando para poder preparar todo sin tener que escribir a mano asi que el comando para generar una migracion es el siguiente

```bash
php artisan make:migration NombreMigracion
```

Es importante usar el comando de artisan ya que por alguna razon, laravel toma registro de las migraciones en una base de datos interna, algo que no es muy conveniente pero asi ces como lo hace.

Algunas de las operaciones que se aplican al crear las columns son las siguientes

- **id()** para generar una columna llamada id, autoincremental, biginteger y con la relacion de clave primaria o primary key.

- **string()** para indicar una columna de tipo **varchar**, recibe de atributos, el nombre y la longitud. 

- **timestamps()** crea dos columnas de tipo **timestamps**, una para la fecha de creacion del registro, y la otra para la fecha de actualizacion.

- **foreignId()** esta funcion nos permite crear la clave de tipo foranea; recibe un parametro de manera obligatoria, el cual indicamos el nombre del campo; esta funcion puede recibir mas parametros para indicar las relaciones pertinentes, pero, si respetamos las convenciones de nombres de laravel, no seria necesario.

- **text()** permite crear una columna de tipo **text**, recibe un parametro, con el cual indicamos el nombre de la columna.

- **enumn()** permite crear una columna de tipo **enum** (selecionable) y recibe dos parametrosm, el nombre de la columna, y los valores seleccionados presentados mediante un **array**. 

- **onDelete()** indica el comportamiento que van a tenewr lkos registros al ser eliminados en una relacion foreanea.

Cuando tenemos definada nuestra migracion o migraciones, podemos usar ek siguiente comando para correr todas migraciones y crear las tablas en la base de datos con el siguiente comando

```bash
php artisan migrate
```

## Llave foranea

Por defecto laravel espera que los campos de relacion sigan la siguiente nomenclatura, `$table->foreingId('category_id')->constrained()->onDelete('cascade');` y esto es una buena practica, pero puede que por diferentes decisiones no puedas seguirla, en ese caso daria un poco de error pues no estamos siguiendo la nomenclatura, aun asi podemos usar otra alternativa para nombrar la llave foranea.

```php

$table->unsignedBigInteger('cat_id');
$table->foreing('cat_id')
      ->references('uuid')
      ->on('catalogos')
      ->onDelete('cascade');
```

Con el anterior ejemplo estamos agregando una llave foranea que no sigue las convenciones tipicas de laravel, ya que no siempre sera posible seguir la convencion o simplemente no te interesa seguir la convencion por otros motivos.

## Controladores

Se usa el siguiente comando para crear el controlador

```bash
php artisan make:controller 
```

El comando anterior crea solo el controlador pero podemos pasar los siguientes parametros para que nos cree el modelo y ademas sea un controlador de tipo resource

```bash
php artisan make:controller Dashboard\Post -r -m
```

De esta forma no solo se crea el controlador si no que tambien genera un modelo y lo asocia con el controlador

## Cear un registro en base de datos

Cuando queremos crear en la base de datos un registro, podemos hacer utilizando el modelo que tenemos asignado a la tabla en la base de datos como se muestr a continuacion

```php
Post::create([
    'title' => 'test title',
    'slug' => 'test slug',
    'content' => 'test content',
    'category_id' => 1,
    'description' => 'test description',
    'posted' => 'not',
    'image' => 'test image',
]);
```

Pero si queremos usar el modelo tambien dememos colocar en el modelo los campos que pueden ser llenados, ya que por defecto laravel no permite llenar ningun campo si no le indicamos lo contrario en modelo como se muestra a continuacion

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'description',
        'posted',
        'image',
    ];

}
```

Con la propiedad `protected $fillable` le indicamos a laravel que campos podemos actualizar mediante el uso del modelo  

## Actualizar

Para actualizar un registro de la base de datos podemos usar el mismo modelos solo que perimo debemos buscar el registro a modidificar con el siguiente metodo

```php
$post = Post::where('title','test title')->get()->first();
```

De esta forma obtenemos el primer registro que encontramos y despues podemos modificar ese mismo registro con el siguiente metodo

```php
$post->update(
    [
        'slug' => 'update slug',
    ]
);
```

Con lo anterior podemos actualizar el registro y si es necesario podemos eliminar el registro de la siguiente manera

```php
$post->delete();
```

De esta forma el registro que previamente buscamos se puede eliminar el registro o actualizarlo