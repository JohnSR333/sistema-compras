@extends('layouts.app')

@section('title','Registrar Detalle de Compra')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1 class="page-title">

                        <i class="fas fa-cart-plus mr-2"></i>
                        Registrar Detalle de Compra

                    </h1>

                </div>

            </div>

        </div>

    </section>

    {{-- ========================= --}}
    {{-- MENSAJES --}}
    {{-- ========================= --}}
    @include('layouts.partial.msg')

    {{-- ========================= --}}
    {{-- CONTENIDO --}}
    {{-- ========================= --}}
    <section class="content">

        <div class="container-fluid">

            <div class="row justify-content-center">

                <div class="col-lg-10">

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-shopping-basket mr-2"></i>
                                Información del Detalle

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- FORMULARIO --}}
                        {{-- ========================= --}}
                        <form
                            method="POST"
                            action="{{ route('detallecompras.store') }}"
                        >

                            @csrf

                            <div class="card-body">

                                <div class="row">

                                    {{-- ========================= --}}
                                    {{-- ORDEN DE COMPRA --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Orden de Compra

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-file-invoice"></i>

                                                    </span>

                                                </div>

                                                <select
                                                    name="ordencompra_id"
                                                    class="form-control modern-input"
                                                    required
                                                >

                                                    <option value="">
                                                        Seleccione una orden
                                                    </option>

                                                    @foreach($ordenes as $orden)

                                                        <option value="{{ $orden->id }}">

                                                            Orden #{{ $orden->id }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- PRODUCTO --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Producto

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-box"></i>

                                                    </span>

                                                </div>

                                                <select
                                                    name="producto_id"
                                                    class="form-control modern-input"
                                                    required
                                                >

                                                    <option value="">
                                                        Seleccione un producto
                                                    </option>

                                                    @foreach($productos as $producto)

                                                        <option value="{{ $producto->id }}">

                                                            {{ $producto->nombre }}

                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- CANTIDAD --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Cantidad

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-sort-numeric-up"></i>

                                                    </span>

                                                </div>

                                                <input
                                                    type="number"
                                                    name="cantidad"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese cantidad"
                                                    required
                                                >

                                            </div>

                                        </div>

                                    </div>

                                    {{-- ========================= --}}
                                    {{-- SUBTOTAL --}}
                                    {{-- ========================= --}}
                                    <div class="col-md-6">

                                        <div class="form-group">

                                            <label class="form-label">

                                                Subtotal

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">

                                                        <i class="fas fa-dollar-sign"></i>

                                                    </span>

                                                </div>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    name="subtotal"
                                                    class="form-control modern-input"
                                                    placeholder="Ingrese subtotal"
                                                    required
                                                >

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- ========================= --}}
                                {{-- CAMPOS OCULTOS --}}
                                {{-- ========================= --}}
                                <input
                                    type="hidden"
                                    name="registradopor"
                                    value="{{ Auth::user()->name }}"
                                >

                            </div>

                            {{-- ========================= --}}
                            {{-- FOOTER --}}
                            {{-- ========================= --}}
                            <div class="card-footer modern-footer">

                                <div class="d-flex justify-content-between">

                                    <a
                                        href="{{ route('detallecompras.index') }}"
                                        class="btn btn-outline-secondary btn-modern"
                                    >

                                        <i class="fas fa-times mr-1"></i>
                                        Cancelar

                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-success btn-modern shadow-sm"
                                    >

                                        <i class="fas fa-save mr-1"></i>
                                        Guardar Detalle

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection