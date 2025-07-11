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
