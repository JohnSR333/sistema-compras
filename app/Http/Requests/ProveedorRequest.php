<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (request()->isMethod('post')) {
            return [
                'nombre'    => 'required|unique:proveedores,nombre',
                'documento' => 'required|unique:proveedores,documento',
                'direccion' => 'nullable',
                'telefono'  => 'required',
                'email'     => 'required|email|unique:proveedores,email',
            ];
        } elseif (request()->isMethod('put')) {
            return [
                'nombre'    => 'required|unique:proveedores,nombre,' . $this->route('proveedor'),
                'documento' => 'required|unique:proveedores,documento,' . $this->route('proveedor'),
                'direccion' => 'nullable',
                'telefono'  => 'required',
                'email'     => 'required|email|unique:proveedores,email,' . $this->route('proveedor'),
            ];
        }
    }
}