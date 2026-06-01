<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Esto es para depuración - lo borramos después
        \Log::info('ProductoRequest - Method: ' . $this->method());
        \Log::info('ProductoRequest - Route product: ' . $this->route('producto'));
    }

    public function rules(): array
    {
        $productoId = $this->route('producto');
        
        // Si es método PUT o PATCH, ignorar el ID actual
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return [
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('productos', 'nombre')->ignore($productoId),
                ],
                'preciocompra' => 'required|numeric|min:0',
                'stockmaximo'  => 'required|integer|min:0',
                'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ];
        }

        // Para método POST (crear)
        return [
            'nombre'       => 'required|unique:productos,nombre',
            'preciocompra' => 'required|numeric|min:0',
            'stockmaximo'  => 'required|integer|min:0',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre del producto es obligatorio',
            'nombre.unique'         => 'Este nombre de producto ya existe',
            'preciocompra.required' => 'El precio de compra es obligatorio',
            'preciocompra.numeric'  => 'El precio debe ser un número',
            'stockmaximo.required'  => 'El stock máximo es obligatorio',
            'stockmaximo.integer'   => 'El stock debe ser un número entero',
            'imagen.image'          => 'El archivo debe ser una imagen',
            'imagen.mimes'          => 'La imagen debe ser JPG, PNG, JPEG o WEBP',
            'imagen.max'            => 'La imagen no puede superar los 2MB',
        ];
    }
}