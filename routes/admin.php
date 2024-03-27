<?php

use App\Http\Controllers\Admin\CategoryComponentController;
use App\Http\Controllers\Admin\ClientesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MarcaController;
use App\Http\Controllers\Admin\DocumentosController;
use App\Http\Controllers\Admin\ComponentesController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\EnvioPedidoController;
use App\Http\Controllers\Admin\KardexController;
use App\Http\Controllers\Admin\OrdenEnsamblajeController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SolicitudComponentesController;
use App\Http\Controllers\OrdenReposicionController;

Route::get('', [HomeController::class, 'index']);

Route::resource('categoriesComponents', CategoryComponentController::class)->except('show')->names('admin.categoriesComponents');

Route::resource('marcas', marcaController::class)->except('show')->names('admin.marcas');

Route::resource('documentos', DocumentosController::class)->except('show')->names('admin.documentos');

Route::resource('componentes', ComponentesController::class)->except('show')->names('admin.componentes');

Route::resource('clientes', ClientesController::class)->except('show')->names('admin.clientes');

Route::resource('users', UsersController::class)->except('show')->names('admin.users');

Route::resource('roles', RoleController::class)->except('show')->names('admin.roles');

Route::resource('pedidos', PedidoController::class)->except('show')->names('admin.pedidos');
Route::get('pedidos/cliente', [PedidoController::class, 'cliente'])->name('admin.pedidos.cliente');
Route::get('pedidos/detalles', [PedidoController::class, 'detalles'])->name('admin.pedidos.detalles');
Route::post('pedidos/FinalizarPedido', [PedidoController::class, 'FinalizarPedido'])->name('admin.pedidos.finalizarPedido');
Route::post('pedidos/EntregarPedido', [PedidoController::class, 'EntregarPedido'])->name('admin.pedidos.entregarPedido');

Route::resource('ordenEnsamblaje', OrdenEnsamblajeController::class)->names('admin.ordenEnsamblaje');
Route::get('ordenEnsamblaje/crearOrden/{idPedido}', [OrdenEnsamblajeController::class, 'crear'])->name('admin.ordenEnsamblaje.crear');
Route::post('ordenEnsamblaje/validar-orden', [OrdenEnsamblajeController::class, 'aprobarOrden'])->name('admin.ordenEnsamblaje.aprobar_orden');
Route::get('ordenEnsamblaje/detalle-pedido', [OrdenEnsamblajeController::class, 'detallePedido'])->name('admin.ordenEnsamblaje.detalle_pedido');



Route::get('solicitudComponentes/index', [SolicitudComponentesController::class, 'index'])->name('admin.solicitudComponentes.index');
Route::get('solicitudComponentes/detalle-orden', [SolicitudComponentesController::class, 'detalleOrden'])->name('admin.solicitudComponentes.detalle_orden');
Route::get('solicitudComponentes/detalle-pedido', [SolicitudComponentesController::class, 'detallePedido'])->name('admin.solicitudComponentes.detalle_pedido');
Route::get('solicitudComponentes/detalle-pdf', [SolicitudComponentesController::class, 'generarPDF'])->name('admin.solicitudComponentes.generar_pdf');
Route::get('solicitudComponentes/estado-solicitud', [SolicitudComponentesController::class, 'EstadoSolicitud'])->name('admin.solicitudComponentes.actualizarEstado');


Route::resource('EnvioPedidos', EnvioPedidoController::class)->except('show')->names('admin.EnvioPedidos');
Route::get('EnvioPedidos/BuscarCodigo', [EnvioPedidoController::class, 'BuscarCodigo'])->name('admin.EnvioPedidos.BuscarCodigo');


Route::resource('Kardex', KardexController::class)->except('show')->names('admin.Kardex');

Route::resource('Reposiciones', OrdenReposicionController::class)->except('show')->names('admin.reposiciones');
Route::get('Reposiciones/aprobar/{id}', [OrdenReposicionController::class, 'aprobar'])->name('admin.reposiciones.aprobar');

Route::resource('Compras', CompraController::class)->except('show')->names('admin.compras');
Route::get('Reposiciones/comprar/{id}/{precioTotal}', [CompraController::class, 'comprar'])->name('admin.compras.comprar');
