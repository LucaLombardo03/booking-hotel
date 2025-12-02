<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Chiunque arrivi qui è già passato dal middleware 'admin'
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:50',
            'zip_code' => 'required|string|max:20',
            'price' => 'required|numeric|min:0',
            'tourist_tax' => 'nullable|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
