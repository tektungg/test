<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'    => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'qty'        => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'    => 'User wajib diisi.',
            'user_id.integer'     => 'User harus berupa angka.',
            'user_id.exists'      => 'User tidak ditemukan.',
            'product_id.required' => 'Produk wajib diisi.',
            'product_id.integer'  => 'Produk harus berupa angka.',
            'product_id.exists'   => 'Produk tidak ditemukan.',
            'qty.required'        => 'Jumlah pesanan wajib diisi.',
            'qty.integer'         => 'Jumlah pesanan harus berupa angka.',
            'qty.min'             => 'Jumlah pesanan minimal :min.',
        ];
    }
}
