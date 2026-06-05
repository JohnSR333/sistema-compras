<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'preciocompra',
        'descripcion',
        'stockmaximo',
        'stock',
        'imagen',
        'estado',
        'registradopor',
    ];

    public function detallesCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'producto_id');
    }
}