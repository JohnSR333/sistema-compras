@extends('layouts.app')

@section('title', 'Ver Orden de Compra')

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
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Número de Orden:</label>
                                        <p><strong>#{{ $orden->id }}</strong></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha:</label>
                                        <p>{{ date('d/m/Y H:i', strtotime($orden->fecha)) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Proveedor:</label>
                                        <p>{{ $orden->proveedor->nombre ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Pago:</label>
                                        <p>{{ ucfirst($orden->tipopago) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total:</label>
                                        <h4 class="text-primary">${{ number_format($orden->total, 2) }}</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Saldo Pendiente:</label>
                                        @if($orden->saldopendiente > 0)
                                            <h4 class="text-danger">${{ number_format($orden->saldopendiente, 2) }}</h4>
                                        @else
                                            <h4 class="text-success">Pagado</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <h4>Detalle de Productos</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orden->detalles as $detalle)
                                        <tr>
                                            <td>{{ $detalle->producto->nombre }}</br><small class="text-muted">{{ $detalle->producto->descripcion ?? '' }}</small></td>
                                            <td>{{ $detalle->cantidad }} uds</br><small class="text-muted">Compra</small></td>
                                            <td>${{ number_format($detalle->producto->preciocompra, 2) }}</br><small class="text-muted">Unitario</small></td>
                                            <td>${{ number_format($detalle->subtotal, 2) }}</br><small class="text-muted">Total</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">TOTAL:</th>
                                            <th>${{ number_format($orden->total, 2) }}</th>
                                        </table>
                                    </tfoot>
                                </table>
                            </div>

                            @if($orden->pagos->count() > 0)
                            <hr>
                            <h4>Registro de Pagos</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Monto</th>
                                            <th>Método de Pago</th>
                                            <th>Registrado por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orden->pagos as $pago)
                                        <tr>
                                            <td>{{ date('d/m/Y H:i', strtotime($pago->fechapago)) }}</td>
                                            <td>${{ number_format($pago->monto, 2) }}</td>
                                            <td>{{ $pago->metodoPago->nombre ?? 'N/A' }}</td>
                                            <td>{{ $pago->registradopor }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="1" class="text-right">TOTAL PAGADO:</th>
                                            <th>${{ number_format($orden->pagos->sum('monto'), 2) }}</th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-2 col-xs-4">
                                    <a href="{{ route('ordencompras.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
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