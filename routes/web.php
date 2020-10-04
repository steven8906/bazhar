<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, BusinessController, TaxesController};
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
    return view('welcome');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/negocios', [BusinessController::class, 'index'])->name('negocios');
Route::post('/negocios/nuevo', [BusinessController::class, 'save']);
Route::post('/negocios/editar', [BusinessController::class, 'edit']);
Route::get('/impuestos', [TaxesController::class, 'index']);
