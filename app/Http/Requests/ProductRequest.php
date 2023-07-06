<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'image' => ['required', 'file', 'mimes:.png,.jpg,.jpeg', 'max:20000'],
            'price' => ['required', 'integer', 'min:1']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
