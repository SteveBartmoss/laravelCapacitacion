<?php

use App\Http\Controllers\PrimerControlador;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function (){
    return view('test');
});

Route::get('/crud', function(){
    $data = ['name'=> 'Raichu', 'age' => 22];
    return view('crud/index',$data);
})->name('crud');

Route::get('/contact1', function(){

    //return redirect()->route('contact2');
    //return to_route('contact2');
    $post = ['name'=>'Steve', 'letters' => ['Raichu', 'Alanita', 'Nanchy'] ];
    return view('contact/contact1',compact('post'));

})->name('contact1');

Route::get('/contact2', function(){
    return view('contact/contact2');
})->name('contact2');

Route::get('/raichu', function(){
    return view('post/raichu');
});

Route::get('/morgan',[PrimerControlador::class, 'index']);

//Route::resource('post', PrimerControlador::class);
Route::get('otro/{post}', [PrimerControlador::class, 'other']);

Route::resource('post', PostController::class);