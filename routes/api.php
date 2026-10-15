<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdentrabajoController;

// Endpoint liviano JSON para el selector de motos en recepción
Route::get('/clientes/{id_cliente}/motos', [OrdentrabajoController::class, 'getMotosPorCliente']);