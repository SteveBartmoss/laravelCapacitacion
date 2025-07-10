# Preparar el ambiente para laravel

Para el desarrollo de laravel se implemento la nueva tecnologia de herd para tener un ambiente listo para desarrollar, para 
instalar esta herramienta se hace desde su pagina [aqui](https://herd.laravel.com/).

El proceso para instalar la herramienta es el mismo que se utiliza con cualquier otra aplicacion, arrastramos la aplicacion a la carpeta de aplicaciones

## Comando para crear el proyecto

Cuando tenemos configurada la herramienta de herd, podemos usar el siguiente comando en la carpeta `Herd` para crear un nuevo proyecto

```bash
laravel new larafirststeps
```

Con este comando creamos el nuevo proyecto del primer curso y podemos empezar con los primeros pasos

## Estructura de carpetas

**/app**

Contiene el codgio central de la aplicacion. Esta es la carpeta central del proyecto en donde pasaremos la mayor parted el tiempo; en este archivo estan casi todas las clases de la aplicacion.

**/bootstrap**

La carpeta de Bootstap contiene el archivo app.php que arranca el framework; el primer archivo que se ejecuta es el **public/index.php** que finalmente carga el mencionado archivo **app.js**. Esta carpeta tambien alberga una carpeta de cache que contiene archivos generados por el framework para la optimizacion del rendimiento, como los archivos de cahce de rutas y servicios. Por lo general, no es necesario hacer cambios aqui.

**/config**

La carpeta de config, como su nombre lo indica, contiene todos los archivos de configuracion de sus aplicacion; base de datos, cors, jetstream, app y muchas mas.

**/database**

La carpeta de database contiene las migraciones de la base de datos, y los seeders. Si lo desea, tambien puede usar esta carppeta para almacenar un base de datos SQLite.

**/lang**

La carpeta lang alberga todos los archivos de idiomas; por defecto, no viene incluida en Laravel 11; puedes publicar la carpeta en caso de que requieras usar multiples lenguajes en tu aplicacion con: 

```bash
php artisan lang:publish
```

**/public**

La carpeta public contiene el archivo **index.php**, que es el punto de entrada para todas las solicitudes que ingresan a su aplicacion y configura la carga autimatica. Esta carpeta tambien alberga archivos que pueden ser manejados por el navegador como imagenes, javascript y css

**/resouces**

La carpeta de resources contiene sus vistas, asi como sus activos sin compilar, como CSS o javascript

**/routes**

La carpeta de routes contiene todas las definiciones de ruta para su aplicacion. De forma predeterminada, se incluyen varios archivos de ruta con Laravel: **web.php, console.php**:
- El archivo **web.php** contiene rutas que son empleadas para manejar la aplicacion web; es decir, la que se consume mediante el navegador; estas rutas estan configuradas para proporcionar estado de sesion, proteccion CSRF y cifrado de cookies.
- El archivo **channels.php** es donde puedes registrar todos los canales de transmision de eventos que admite tu aplicacion.

A partir de Laravel 11, para publicar los siguientes archivos que fueron marcados como opcionales:

- El archivo **api.php** contiene las rutas para la creacion de una Api Rest; estas rutas estan diseñadas para no tener estado, por lo que las solicitudes que ingresan a la aplicacion a traves de estas rutas deben autenticarse mediante tokens y no tendran acceso al estado de la sesion.
- El archivo **console.php** es donde puedes registar todos los canales de transmision de eventos que admite tu aplicacion.

Debemos de ejecutar los comandos de artisan:

```bash
php artisan install:api
php artisan install:broadcasting
```

**/storage**

La carpeta storage contiene sus registros, plantillas Blade compiladas, sesiones basada en archivos, caches de archivos y otros archivos generados por el framework; esta carpeta se puede usar para almacenar cualquier generado por su aplicacion.

**/test**

La carpeta de test contiene sus pruebas automatizadas; es decir, las pruebas unitarias de PHPUnit.

**/vendor**

La carpeta de **vendor** contiene sus dependencias de Composer.

**/app**

La mayor parte de la aplicacion se encuentra en la carpeta de app, que como mencionamos antes, es donde pasaremos la mayor parte de nuestro tiempo; la matoria de las clases se encuentran en esta carpeta y podemos definir archivos con configuraciones para distintos propositos.

En esta carpeta, se ubican otras carpetas; como se puede ver a continuacion:

**/Http**

La carpeta Http contiene sus controladores, middleware y solicitudes de formulario.

**/Models**

La carpeta de models contiene todas las clases de modelos de Eloquent, Cada tabla de la base de datos tiene un "Modelo" correspondiente que se utiliza para interactuar con esa tabla. Los modelos le permiten consultar datos en sus tablas, asi como insertar, actualizar y eliminar registros en tabla.


## Router del front del proyecto

Al igual que en otros framework de web como vue o react, laravel incorpora un router para mostrar las diferentes vistas de la aplicacion, esto se realiza en el archivo **web.php** ya que es aqui donde las rutas se definen para las vistas de la aplicacion, en este caso el archivo tiene este tipo de estructura

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

### Rutas

Las rutas son un esquema flexible que tenemos para vincular una URI a un proceso funcional: y este proveso funcional puede ser:
- Un callback, que es una funcion local definida en las mimas rutas.

- Un controlador, que es una clase aparte.

- Un componente, que es como un controlador, pero mas flexible.

Si revisamos en la carpeta de routes; veremos que existen 4 archivos:

- api: Para definir rutas de nuestras Apis Rest

- channel: Para la comunicacion fullduplex con los canales.

- console: Para crear comandos con artisan.

- web: Las rutas para la aplicacion web


Las rutas pueden ser de los siguientes tipos: 

- POST crear un recurso con la funcion post()
- GET leer un recurso o coleccion con la funcion
- PUT actualizar un recurso con la funcion
- PATCH actualizar un recurso con la funcion
- DELETE eliminar un reurso con la funcion

### Paso de parametros a una ruta

Como en otros frameworks, se pueden mandar parametros por la ruta, para poder mostrar esa informacion en la vista, a cotinuacion de muestra la forma de pasar data a una rota

```php
Route::get('/crud', function(){
    $data = ['name'=> 'Raichu', 'age' => 22];
    return view('crud/index',$data);
});
```

La forma de poder usar estas variables en nuestra vista es la siguiente: 

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crud XD</h1>

    {{ $name }}
    {{ $age }}
    
</body>
</html>
```

Se pueden los dobles {{}} como en otros frameworks para poder mostar la informacion que se manda a la vista.

### Nombre de las rutas

Cuando queremos navegar entre diferentes partes de la aplicacion, podemos usar las etiquetas <a>, pero uno de los problemas que podriamos tener es que si cambiamos la ruta todas las etiquetas que tenian la ruta anterior se veran afectas, pero una forma de evitar es usando el name que le asignamos a una ruta.

```php
Route::get('/crud', function(){
    $data = ['name'=> 'Raichu', 'age' => 22];
    return view('crud/index',$data);
})->name('crud');
```

De esta forma podemos usar la funcion `route()` en la etiqueta <a> para poder 
navegar a la ruta que queremos sin importar que ek path de la ruta cambie

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>La guia del internet por steve</h1>
    <h4>No le preguntes a la documentacion, preguntame a mi</h4>
    <a href="{{ route('crud') }}">crud</a>
</body>
</html>
```


## Modelo vista controlador

Laravel usa el patron de Modelo, Vista, Controlador (MVC); esto mantiene cada capa como partes separadas, pero funciona en conjunto como un todo:

- Los modelos admnistran los datos de la aplicacion y ayudan a hacer cumplir las reglas comerciales especiales que la aplicacion pueda necesitar.

- las vistas son archivos simples, con poca o ninguna logica, que muestran la informacion al usuario; estan compuestas de HTML para la estatica y de PHP para la parte dinamica; aparte de CSS y Javascript.

- Los controladores actuan como un codigo adhesivo, ordenando datos entre la vista( o el usario que los esta viendo) y el almacenamiento de datos, es decir, el modelo; este componente es done generalmente pasamos mas tiempo (junto con la vista) ya que, tenemos que organizar todo lo que vamos a ver en la vista, aplicar validaciones y demas reglas segun la logica que programemos en nuestra aplicacion.
