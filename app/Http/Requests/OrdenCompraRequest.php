<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenCompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'tipopago' => 'required|in:contado,credito',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.required' => 'Debe seleccionar un proveedor',
            'fecha.required' => 'La fecha es obligatoria',
            'tipopago.required' => 'Debe seleccionar un tipo de pago',
            'productos.required' => 'Debe agregar al menos un producto',
            'productos.*.cantidad.min' => 'La cantidad debe ser al menos 1',
        ];
    }
}