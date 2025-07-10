<?php

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
    return view('contact/contact1',['name'=>'Steve', 'letters' => ['Raichu', 'Alanita', 'Nanchy'] ]);

})->name('contact1');

Route::get('/contact2', function(){
    return view('contact/contact2');
})->name('contact2');