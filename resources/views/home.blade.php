@extends('layouts.app')

@section('title','Panel De Control')

@section('content')

<div class="content-wrapper">

    <!-- =========================
         Encabezado
    ========================== -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        @yield('title')
                    </h1>
                </div>
            </div>

        </div>
    </div>

    <!-- =========================
         Contenido principal
    ========================== -->
    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <!-- =========================
                     Proveedores
                ========================== -->
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">

                        <div class="inner">
                            <h3>{{ $totalProveedores }}</h3>
                            <p>Total Proveedores</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-people-carry"></i>
                        </div>

                        <a
                            href="{{ route('proveedores.index') }}"
                            class="small-box-footer"
                        >
                            Más Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>

                    </div>

                </div>

                <!-- =========================
                     Productos
                ========================== -->
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-success">

                        <div class="inner">
                            <h3>{{ $totalProductos }}</h3>
                            <p>Productos Registrados</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>

                        <a
                            href="{{ route('productos.index') }}"
                            class="small-box-footer"
                        >
                            Más Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>

                    </div>

                </div>

                <!-- =========================
                     Órdenes de compra
                ========================== -->
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">

                        <div class="inner">
                            <h3>{{ $totalOrdenes }}</h3>
                            <p>Órdenes de Compra</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>

                        <a
                            href="{{ route('ordencompras.index') }}"
                            class="small-box-footer"
                        >
                            Más Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>

                    </div>

                </div>

                <!-- =========================
                     Pagos
                ========================== -->
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">

                        <div class="inner">
                            <h3>{{ $totalPagos }}</h3>
                            <p>Pagos Registrados</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-credit-card"></i>
                        </div>

                        <a
                            href="{{ route('pagos.index') }}"
                            class="small-box-footer"
                        >
                            Más Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>

                    </div>

                </div>

                <!-- =========================
                     Métodos de pago
                ========================== -->
                <div class="col-lg-3 col-6">

                    <div class="small-box bg-primary">

                        <div class="inner">
                            <h3>{{ $totalMetodos }}</h3>
                            <p>Métodos de Pago</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-money-check-alt"></i>
                        </div>

                        <a
                            href="{{ route('metodopagos.index') }}"
                            class="small-box-footer"
                        >
                            Más Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection