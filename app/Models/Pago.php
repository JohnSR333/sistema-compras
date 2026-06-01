<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'ordencompra_id',
        'fechapago',
        'monto',
        'metodopago_id',
        'registradopor',
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class, 'ordencompra_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodopago_id');
    }
}