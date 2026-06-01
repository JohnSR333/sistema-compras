@extends('layouts.app')

@section('title','Ver Proveedor')

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
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Nombre</label>
                                                <p>{{ $proveedor->nombre }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Documento</label>
                                                <p>{{ $proveedor->documento }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Teléfono</label>
                                                <p>{{ $proveedor->telefono }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email</label>
                                                <p>{{ $proveedor->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Dirección</label>
                                                <p>{{ $proveedor->direccion ?? 'Sin dirección' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Registrado por</label>
                                                <p>{{ $proveedor->registradopor }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Estado</label>
                                                <p>
                                                    @if($proveedor->estado == 1)
                                                        <span class="badge badge-success">Activo</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactivo</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('proveedores.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
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