@extends('layouts.app')

@section('title', 'Crear Orden de Compra')

@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 style="font-weight: bold; color: #343a40;">Crear Orden de Compra</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('ordencompras.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partial.msg')

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice mr-2"></i> Información de la Orden
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('ordencompras.store') }}" id="ordenForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Proveedor <strong style="color:red;">(*)</strong></label>
                                            <select name="proveedor_id" class="form-control" required>
                                                <option value="">Seleccione un proveedor</option>
                                                @foreach($proveedores as $proveedor)
                                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha <strong style="color:red;">(*)</strong></label>
                                            <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipo de Pago <strong style="color:red;">(*)</strong></label>
                                            <select name="tipopago" class="form-control" id="tipopagoSelect" required>
                                                <option value="contado">Contado</option>
                                                <option value="credito">Crédito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="metodopagoDiv">
                                        <div class="form-group">
                                            <label>Método de Pago <strong style="color:red;">(*)</strong></label>
                                            <select name="metodopago_id" class="form-control" required>
                                                <option value="">Seleccione un método</option>
                                                @foreach($metodosPago as $metodo)
                                                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h4>Productos</h4>
                                
                                <div id="productos-container">
                                    <div class="row producto-item mb-3">
                                        <div class="col-md-5">
                                            <select name="productos[0][id]" class="form-control producto-select" required>
                                                <option value="">Seleccione un producto</option>
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}" 
                                                            data-precio="{{ $producto->preciocompra }}"
                                                            data-stock-actual="{{ $producto->stock }}"
                                                            data-stock-maximo="{{ $producto->stockmaximo }}">
                                                        {{ $producto->nombre }} - 
                                                        Precio: ${{ number_format($producto->preciocompra, 2) }} | 
                                                        Stock: {{ $producto->stock }} / {{ $producto->stockmaximo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="productos[0][cantidad]" class="form-control cantidad-input" placeholder="Cantidad" min="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="subtotal-text">Subtotal: $0</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="stock-disponible badge badge-info">Disponible: --</span>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-producto" class="btn btn-sm btn-info mt-2">
                                    <i class="fas fa-plus"></i> Agregar Producto
                                </button>

                                <hr>

                                <div class="row">
                                    <div class="col-md-6 offset-md-6">
                                        <h3>Total: <span id="total-display" class="text-primary">$0.00</span></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-flat">Registrar</button>
                                <a href="{{ route('ordencompras.index') }}" class="btn btn-danger btn-flat">Atras</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let productoIndex = 1;

    // Mostrar/ocultar método de pago - AHORA SIEMPRE VISIBLE
    // El método de pago siempre se muestra porque es obligatorio para contado
    // Si quieres ocultarlo para crédito, descomenta el código de abajo
    
    // const tipopagoSelect = document.getElementById('tipopagoSelect');
    // const metodopagoDiv = document.getElementById('metodopagoDiv');
    
    // tipopagoSelect.addEventListener('change', function() {
    //     if (this.value === 'contado') {
    //         metodopagoDiv.style.display = 'block';
    //         document.querySelector('select[name="metodopago_id"]').required = true;
    //     } else {
    //         metodopagoDiv.style.display = 'none';
    //         document.querySelector('select[name="metodopago_id"]').required = false;
    //     }
    // });

    // Calcular total
    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.producto-item').forEach(row => {
            const select = row.querySelector('.producto-select');
            const cantidad = row.querySelector('.cantidad-input').value;
            const precio = select.options[select.selectedIndex]?.dataset.precio;
            if (precio && cantidad && cantidad > 0) {
                total += parseFloat(precio) * parseInt(cantidad);
                row.querySelector('.subtotal-text').textContent = 'Subtotal: $' + (parseFloat(precio) * parseInt(cantidad)).toFixed(2);
            } else {
                row.querySelector('.subtotal-text').textContent = 'Subtotal: $0';
            }
        });
        document.getElementById('total-display').textContent = '$' + total.toFixed(2);
    }

    // Actualizar disponibilidad
    function actualizarDisponibilidad(select, cantidadInput, stockDisponibleSpan) {
        const stockActual = parseInt(select.options[select.selectedIndex]?.dataset.stockActual || 0);
        const stockMaximo = parseInt(select.options[select.selectedIndex]?.dataset.stockMaximo || 0);
        const disponible = stockMaximo - stockActual;
        
        if (disponible > 0) {
            stockDisponibleSpan.textContent = `Disponible: ${disponible} uds`;
            stockDisponibleSpan.className = 'badge badge-success';
        } else {
            stockDisponibleSpan.textContent = 'Disponible: 0 (stock lleno)';
            stockDisponibleSpan.className = 'badge badge-danger';
        }
        
        // Validar cantidad y ajustar
        const cantidad = parseInt(cantidadInput.value);
        if (cantidad > disponible && disponible > 0) {
            cantidadInput.value = disponible;
            alert(`⚠️ Solo puedes comprar hasta ${disponible} unidades de este producto.`);
            calcularTotal();
        }
    }

    // Configurar fila
    function configurarFila(row, showDeleteButton = true) {
        const select = row.querySelector('.producto-select');
        const cantidadInput = row.querySelector('.cantidad-input');
        const stockDisponibleSpan = row.querySelector('.stock-disponible');
        
        const update = () => {
            actualizarDisponibilidad(select, cantidadInput, stockDisponibleSpan);
            calcularTotal();
        };
        
        select.addEventListener('change', update);
        cantidadInput.addEventListener('keyup', update);
        cantidadInput.addEventListener('change', update);
        
        update();
    }

    // VALIDACIÓN ANTES DE ENVIAR EL FORMULARIO
    document.getElementById('ordenForm').addEventListener('submit', function(e) {
        let errores = [];
        
        // Validar que se haya seleccionado un método de pago
        const metodopago = document.querySelector('select[name="metodopago_id"]').value;
        if (!metodopago) {
            errores.push('Debe seleccionar un método de pago');
        }
        
        document.querySelectorAll('.producto-item').forEach(row => {
            const select = row.querySelector('.producto-select');
            const cantidad = parseInt(row.querySelector('.cantidad-input').value);
            
            if (select.value && cantidad) {
                const stockActual = parseInt(select.options[select.selectedIndex]?.dataset.stockActual || 0);
                const stockMaximo = parseInt(select.options[select.selectedIndex]?.dataset.stockMaximo || 0);
                const disponible = stockMaximo - stockActual;
                const productoNombre = select.options[select.selectedIndex]?.text.split(' -')[0];
                
                if (cantidad > disponible) {
                    errores.push(`"${productoNombre}": Solo puedes comprar ${disponible} unidades (Stock actual: ${stockActual}, Máximo: ${stockMaximo})`);
                }
            }
        });
        
        if (errores.length > 0) {
            e.preventDefault();
            alert('❌ ERRORES:\n\n' + errores.join('\n\n'));
        }
    });

    // Configurar filas existentes
    document.querySelectorAll('.producto-item').forEach(row => configurarFila(row, false));

    // Agregar producto
    document.getElementById('add-producto').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const template = document.querySelector('.producto-item:first');
        const newRow = template.cloneNode(true);
        
        newRow.querySelector('select').value = '';
        newRow.querySelector('.cantidad-input').value = '';
        newRow.querySelector('.subtotal-text').textContent = 'Subtotal: $0';
        newRow.querySelector('.stock-disponible').textContent = 'Disponible: --';
        newRow.querySelector('.stock-disponible').className = 'badge badge-info';
        
        newRow.querySelector('select').name = `productos[${productoIndex}][id]`;
        newRow.querySelector('.cantidad-input').name = `productos[${productoIndex}][cantidad]`;
        
        container.appendChild(newRow);
        configurarFila(newRow, true);
        productoIndex++;
    });

    // Inicializar
    // tipopagoSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection