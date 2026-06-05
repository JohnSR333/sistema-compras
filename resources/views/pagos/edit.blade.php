@extends('layouts.app')

@section('title', 'Editar Pago')

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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <form method="POST" action="{{ route('pagos.update', $pago->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Orden de Compra <strong style="color:red;">(*)</strong></label>
                                            <select name="ordencompra_id" class="form-control select2" required>
                                                @foreach($ordenes as $orden)
                                                    <option value="{{ $orden->id }}" {{ $pago->ordencompra_id == $orden->id ? 'selected' : '' }}>
                                                        Orden #{{ $orden->id }} - {{ $orden->proveedor->nombre }} - Fecha: {{ date('d/m/Y', strtotime($orden->fecha)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Monto <strong style="color:red;">(*)</strong></label>
                                            <input type="number" step="0.01" name="monto" class="form-control" value="{{ $pago->monto }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Método de Pago <strong style="color:red;">(*)</strong></label>
                                            <select name="metodopago_id" class="form-control select2" required>
                                                @foreach($metodos as $metodo)
                                                    <option value="{{ $metodo->id }}" {{ $pago->metodopago_id == $metodo->id ? 'selected' : '' }}>
                                                        {{ $metodo->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('pagos.index') }}" class="btn btn-danger btn-block btn-flat">Atras</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: 'Buscar orden por número, proveedor o fecha',
            allowClear: true,
            language: 'es'
        });
    });
</script>
@endpush

@endsection