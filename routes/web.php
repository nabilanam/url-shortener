<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/{id}',function ($id){
    $shortener = new \App\Services\UrlShortener();
    try{
        $url = $shortener->unshorten($id);
        return redirect()->away($url);
    }catch (Exception $e){
        return 'Invalid Key';
    }
});
