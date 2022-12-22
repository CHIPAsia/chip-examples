<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Controller::class, 'index']);

Route::post('/payment', [Controller::class, 'create']);

Route::get('/cc_form', function () {
  return view('credit_card_form');
});

Route::post('/cc_form', [Controller::class, 'cc_post']);
