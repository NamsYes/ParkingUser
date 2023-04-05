<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;


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

Route::middleware('admin')->group(function () {
    Route::get ('/users', [UsersController::class, 'index']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect('/home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/unverified', function (){
    return view('unverified');
});


//SI L'USER EST CONNECTÉ IL ARRIVE SUR CETTE PAGE

Route::middleware('Active')->group(function () {

    Route::get('/home',[HomeController::class, 'index'])->name('home');;
    Route::get('/home/delete{id}',[HomeController::class, 'deleteresa'])->name('home.deleteresa');
    Route::get('/home/cancel{id}',[HomeController::class, 'cancelresa'])->name('home.cancelresa');
    Route::get('/home/add',[HomeController::class, 'giveplace'])->name('home.attrib');


});

require __DIR__.'/auth.php';
