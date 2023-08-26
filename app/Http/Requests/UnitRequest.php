<?php

namespace App\Http\Requests;

use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    private function requiredCondition()
    {
        return Rule::requiredIf(function () {
            return $this->method() == 'POST';
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            'name' => [$this->requiredCondition(), 'min:3', 'max:255', 'string'],
            'price' => [$this->requiredCondition(), 'integer'],
            'description' => [$this->requiredCondition(), 'min:3', 'max:65535', 'string'],
            'type' => [$this->requiredCondition(), 'min:3', 'max:255', 'string'],
            'location' => [$this->requiredCondition(), 'min:3', 'max:255', 'string'],
            'number_of_rooms' => [$this->requiredCondition(), 'integer'],
            'number_of_bathrooms' => [$this->requiredCondition(), 'integer'],
            'area' => [$this->requiredCondition(), 'integer']
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'Name is not valid',
            'price' => 'Price is not valid',
            'description' => 'Description is not valid',
            'type' => 'Type is not valid',
            'location' => 'Location is not valid',
            'number_of_rooms' => 'Number of rooms is not valid',
            'number_of_bathrooms' => 'Number of bathrooms is not valid',
            'area' => 'Area is not valid',
        ];
    }
}
