<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Вход
Route::get('/', [IndexController::class,'start']);
Route::post('/',[IndexController::class, 'login'])->name('login');
//Регистрация
Route::get('/reg', [IndexController::class,'reg']);
Route::post('/reg',[IndexController::class, 'reg'])->name('reg');
Route::post('/registered',[IndexController::class, 'register'])->name('register');
//Контент страницы
Route::get('/main/{parameter}', [IndexController::class,'content']);
Route::get('/admin', [IndexController::class,'admin']);
//Выход
Route::get('/q', [IndexController::class,'quit']);
Route::post('/q',[IndexController::class, 'quit'])->name('quit');
//Курс
Route::get('/kurs/{id}', [IndexController::class, 'kurs'])->name('kurs1');
//По языку
Route::get('/lang/{name}', [IndexController::class, 'language']);
//запись
Route::post('/zapis', [IndexController::class, 'zapis'])->name('zapis');
//курсы юзера
Route::get('/mycab', [IndexController::class,'userkurs'])->name('mycab');
//отписка
Route::post('/leave', [IndexController::class,'userleave'])->name('userleave');
//добавление записи
Route::get('/add', [IndexController::class,'addform']);
Route::post('/add', [IndexController::class,'store'])->name('addform');
//удаление записи
Route::get('/del/{id}', [IndexController::class, 'delete'])->name('delete');


