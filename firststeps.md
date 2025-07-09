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
