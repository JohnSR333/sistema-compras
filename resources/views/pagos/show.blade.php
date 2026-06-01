@extends('layouts.app')

@section('title', 'Ver Pago')

@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-secondary" style="font-size: 1.75rem; font-weight: 500;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ID del Pago:</label>
                                        <p><strong>#{{ $pago->id }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Orden de Compra:</label>
                                        <p>
                                            <a href="{{ route('ordencompras.show', $pago->ordenCompra->id) }}" class="text-primary">
                                                Orden #{{ $pago->ordenCompra->id }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Proveedor:</label>
                                        <p>{{ $pago->ordenCompra->proveedor->nombre ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha de Pago:</label>
                                        <p>{{ date('d/m/Y H:i', strtotime($pago->fechapago)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Monto Pagado:</label>
                                        <h4 class="text-primary">${{ number_format($pago->monto, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Método de Pago:</label>
                                        <p><span class="badge badge-info">{{ $pago->metodoPago->nombre ?? 'N/A' }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registrado por:</label>
                                        <p>{{ $pago->registradopor }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('pagos.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection