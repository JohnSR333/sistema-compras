@extends('layouts.app')

@section('title','Detalles de Compras')

@section('content')

<div class="content-wrapper">

    {{-- ========================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================= --}}
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-3">

                <div class="col-sm-6">

                    <h1 class="page-title">

                        <i class="fas fa-clipboard-list mr-2"></i>
                        Gestión de Detalles de Compra

                    </h1>

                </div>

                <div class="col-sm-6 text-right">

                    <a
                        href="{{ route('detallecompras.create') }}"
                        class="btn btn-primary btn-modern"
                    >

                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Detalle

                    </a>

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

            <div class="row">

                <div class="col-12">

                    <div class="card modern-card">

                        {{-- ========================= --}}
                        {{-- HEADER --}}
                        {{-- ========================= --}}
                        <div class="card-header modern-card-header">

                            <h3 class="card-title">

                                <i class="fas fa-shopping-cart mr-2"></i>
                                Lista de Detalles

                            </h3>

                        </div>

                        {{-- ========================= --}}
                        {{-- TABLA --}}
                        {{-- ========================= --}}
                        <div class="card-body">

                            <div class="table-responsive">

                                <table
                                    id="example1"
                                    class="table custom-table table-hover datatable"
                                >

                                    <thead>

                                        <tr>

                                            <th>ID</th>

                                            <th>Orden</th>

                                            <th>Producto</th>

                                            <th>Cantidad</th>

                                            <th>Subtotal</th>

                                            <th>Registrado por</th>

                                            <th width="120px">Acciones</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($detalles as $detalle)

                                            <tr>

                                                {{-- ID --}}
                                                <td>

                                                    <strong>

                                                        #{{ $detalle->id }}

                                                    </strong>

                                                </td>

                                                {{-- ORDEN --}}
                                                <td>

                                                    <span class="badge badge-info px-3 py-2">

                                                        Orden #{{ $detalle->ordencompra_id }}
<br>
<small>
Proveedor: {{ $detalle->ordenCompra->proveedor->nombre ?? 'N/A' }}
</small>
                                                    </span>

                                                </td>

                                                {{-- PRODUCTO --}}
                                                <td>

                                                    <strong>

                                                        {{ $detalle->producto->nombre ?? 'Producto no encontrado' }}

                                                    </strong>

                                                </td>

                                                {{-- CANTIDAD --}}
                                                <td>

                                                    <span class="badge badge-primary px-3 py-2">

                                                        {{ $detalle->cantidad }}

                                                    </span>

                                                </td>

                                                {{-- SUBTOTAL --}}
                                                <td>

                                                    <span class="badge badge-success px-3 py-2">

                                                        ${{ number_format($detalle->subtotal, 2) }}

                                                    </span>

                                                </td>

                                                {{-- REGISTRADO --}}
                                                <td>

                                                    <span class="badge badge-secondary px-3 py-2">

                                                        {{ $detalle->registradopor }}

                                                    </span>

                                                </td>

                                                {{-- ACCIONES --}}
                                                <td class="text-center">

                                                    <div class="btn-group btn-group-sm">

                                                        {{-- VER --}}
                                                        <a
                                                            href="{{ route('detallecompras.show', $detalle->id) }}"
                                                            class="btn btn-info btn-action"
                                                            title="Ver detalle"
                                                        >

                                                            <i class="fas fa-eye"></i>

                                                        </a>

                                                        {{-- EDITAR --}}
                                                        <a
                                                            href="{{ route('detallecompras.edit', $detalle->id) }}"
                                                            class="btn btn-primary btn-action"
                                                            title="Editar detalle"
                                                        >

                                                            <i class="fas fa-pencil-alt"></i>

                                                        </a>

                                                        {{-- ELIMINAR --}}
                                                        <form
                                                            class="d-inline delete-form"
                                                            action="{{ route('detallecompras.destroy', $detalle->id) }}"
                                                            method="POST"
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-action"
                                                                title="Eliminar detalle"
                                                            >

                                                                <i class="fas fa-trash-alt"></i>

                                                            </button>

                                                        </form>

                                                    </div>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                            {{-- ========================= --}}
                            {{-- PAGINACIÓN --}}
                            {{-- ========================= --}}
                            <div class="mt-4 d-flex justify-content-center">

                                {{ $detalles->links() }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection