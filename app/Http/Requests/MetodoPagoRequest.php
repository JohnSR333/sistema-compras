<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MetodoPagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('metodopago');

        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('metodopagos', 'nombre')->ignore($id),
            ],
            'descripcion' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del método de pago es obligatorio',
            'nombre.unique' => 'Este método de pago ya existe',
        ];
    }
}