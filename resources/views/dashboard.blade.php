@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 style="margin-bottom: 5px; font-weight: 800;">Panel de Control Operativo</h1>
            <p style="color: #6c757d; margin-top: 0; margin-bottom: 25px;">Gestión de servicios automotrices y liquidación transparente.</p>
        </div>
    </div>

    <div class="row">
        <!-- Tarjeta Clientes -->
        <div class="col-3">
            <div class="card border-primary">
                <h3 class="card-title">Clientes</h3>
                <p class="card-text">Registro integral de usuarios y datos de identidad (NIT/CI) de Trinidad.</p>
                <a href="{{ url('/clientes') }}" class="btn btn-primary" style="margin-top: 15px;">Gestionar Clientes</a>
            </div>
        </div>

        <!-- Tarjeta Motocicletas -->
        <div class="col-3">
            <div class="card border-success">
                <h3 class="card-title">Motocicletas</h3>
                <p class="card-text">Control del parque automotor, marcas, modelos y placas del taller.</p>
                <a href="{{ url('/motos') }}" class="btn btn-success" style="margin-top: 15px;">Ver Historial</a>
            </div>
        </div>

        <!-- Tarjeta Órdenes -->
        <div class="col-3">
            <div class="card border-warning">
                <h3 class="card-title">Órdenes</h3>
                <p class="card-text">Apertura transaccional, asignación de técnicos y comisiones fijos.</p>
                <a href="{{ url('/ordenes/create') }}" class="btn btn-warning" style="margin-top: 15px;">Nueva Orden</a>
            </div>
        </div>

        <!-- Tarjeta Liquidación -->
        <div class="col-3">
            <div class="card border-danger">
                <h3 class="card-title">Liquidación 50%</h3>
                <p class="card-text">Reporte transparente de mano de obra bruta y ganancias acumuladas.</p>
                <a href="{{ url('/admin/ganancias') }}" class="btn btn-danger" style="margin-top: 15px;">Ver Reporte</a>
            </div>
        </div>

        <!-- Tarjeta Notas Impresas -->
        <div class="col-3">
            <div class="card border-info">
                <h3 class="card-title">Notas Impresas</h3>
                <p class="card-text">Reporte de notas de servicio emitidas al cliente por día, semana o mes.</p>
                <a href="{{ route('admin.notasImpresas') }}" class="btn btn-info" style="margin-top: 15px;">Ver Reporte</a>
            </div>
        </div>
    </div>
</div>
@endsection