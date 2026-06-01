@extends('layouts.app')

@section('title','Ver Producto')

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
                        <div class="card-header bg-secondary" style="font-size: 1.75rem; font-weight: 500; line-height: 1.2; margin-bottom: 0.5rem;">
                            @yield('title')
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    @if($producto->imagen)
                                        <img src="{{ asset($producto->imagen) }}" style="width:200px; height:200px; object-fit:cover; border-radius:12px;">
                                    @else
                                        <div style="width:200px; height:200px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border-radius:12px; margin:auto;">
                                            <i class="fas fa-box" style="font-size:60px; color:#94a3b8;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <p><strong>{{ $producto->nombre }}</strong></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Precio de Compra</label>
                                                <p><strong>${{ number_format($producto->preciocompra, 2) }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Stock Actual</label>
                                                <p><strong>{{ $producto->stock }} unidades</strong></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Stock Máximo</label>
                                                <p><strong>{{ $producto->stockmaximo }} unidades</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <p>
                                                    @if($producto->estado == 1)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Registrado por</label>
                                                <p>{{ $producto->registradopor }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <p>{{ $producto->descripcion ?? 'Sin descripción' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('productos.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
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