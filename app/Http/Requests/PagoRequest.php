<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ordencompra_id' => 'required|exists:ordencompras,id',
            'metodopago_id' => 'required|exists:metodopagos,id',
            'monto' => 'required|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'ordencompra_id.required' => 'Debe seleccionar una orden de compra',
            'metodopago_id.required' => 'Debe seleccionar un método de pago',
            'monto.required' => 'El monto es obligatorio',
            'monto.min' => 'El monto debe ser mayor a 0',
        ];
    }
}