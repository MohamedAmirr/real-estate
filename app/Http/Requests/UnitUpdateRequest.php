<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['min:3', 'max:255', 'string'],
            'price' => ['integer'],
            'description' => ['min:3', 'max:65535', 'string'],
            'type' => ['min:3', 'max:255', 'string'],
            'location' => ['min:3', 'max:255', 'string'],
            'number_of_rooms' => ['integer'],
            'number_of_bathrooms' => ['integer'],
            'area' => ['integer']
        ];
    }
}
