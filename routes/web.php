<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController, BusinessController, TaxesController,
                          ProvidersController, PresentationController, ProductController, 
                          SalesMediumController, UtilitiesController, OrdersController};
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
Route::post('/impuestos/nuevo', [TaxesController::class, 'new']);
Route::get('/proveedores',[ProvidersController::class, 'index']);
Route::post('/proveedores/nuevo', [ProvidersController::class, 'new']);
Route::get('/presentaciones',[PresentationController::class, 'index']);
Route::post('/presentaciones/nuevo',[PresentationController::class, 'new']);
Route::get('/productos',[ProductController::class, 'index']);
Route::get('/nuevo-producto',[ProductController::class,'newProduct']);
Route::post('/productos/nuevo',[ProductController::class, 'new']);
Route::get('/medios-venta',[SalesMediumController::class,'index']);
Route::post('/medios-venta/nuevo',[SalesMediumController::class,'new']);
Route::get('/utilidades',[UtilitiesController::class,'index']);
Route::get('/pedidos',[OrdersController::class,'index']);


