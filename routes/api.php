<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\BooksRentalController;
use OpenApi\Generator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/swagger.json', function () {
    header('Content-Type: application/x-yaml');
    return Generator::scan([ app_path(), ])->toJson();
});

//Route::post('/auth/register',       [UserController::class, 'createUser']);
//Route::post('/auth/login',          [UserController::class, 'loginUser']);


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'api', 'prefix' => 'user'], function ($router) {
    Route::patch('update',                          [UserController::class, 'update']);
    Route::get('users',                             [UserController::class, 'users']);
    Route::post('usersfiltersearch',                [UserController::class, 'usersFilterSearch']);
});

Route::group(['middleware' => 'api', 'prefix' => 'author'], function ($router) {
    Route::post('register', [AuthorsController::class, 'register']);
    Route::post('update', [AuthorsController::class, 'update']);
    Route::get('authors', [AuthorsController::class, 'authors']);
    Route::delete('delete', [AuthorsController::class, 'delete']);
});

Route::group(['middleware' => 'api', 'prefix' => 'books'], function ($router) {
    Route::post('register', [BooksController::class, 'register']);
    Route::post('update', [BooksController::class, 'update']);
    Route::get('books', [BooksController::class, 'books']);
    Route::delete('delete', [BooksController::class, 'delete']);
});

Route::group(['middleware' => 'api', 'prefix' => 'rental'], function ($router) {
    Route::post('register', [BooksRentalController::class, 'register']);
    Route::get('list', [BooksRentalController::class, 'list']);
});

Route::get('email-test', function(){
    $details['email'] = 'rafael.frotac@gmail.com';

    dispatch(new App\Jobs\SendEmailJob($details));

    dd('done');

});