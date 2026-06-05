@if($orden->pagos->count() > 0)
<h4>Registro de Pagos</h4>
<table class="table">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Método</th>
         </tr>
    </thead>
    <tbody>
        @foreach($orden->pagos as $pago)
        <tr>
            <td>{{ date('d/m/Y', strtotime($pago->fechapago)) }}</br><small>Hora: {{ date('H:i', strtotime($pago->fechapago)) }}</small></td>
            <td>${{ number_format($pago->monto, 2) }}</br><small>Pagado</small></td>
            <td>{{ $pago->metodoPago->nombre ?? 'N/A' }}</br><small>Método</small></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif