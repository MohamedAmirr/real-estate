<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitStoreRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255', 'string'],
            'price' => ['required', 'integer'],
            'description' => ['required', 'min:3', 'max:65535', 'string'],
            'type' => ['required', 'min:3', 'max:255', 'string'],
            'location' => ['required', 'min:3', 'max:255', 'string'],
            'number_of_rooms' => ['required', 'integer'],
            'number_of_bathrooms' => ['required', 'integer'],
            'area' => ['required', 'integer']
        ];
    }
}
