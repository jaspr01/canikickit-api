<?php

namespace App\Http\Requests\Company;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'box' => 'nullable|string|max:255',
            'zipCode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            // TODO: Validate IBAN by checksum
            'iban' => 'required|string|max:255',
            'bic' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
        ];

        // Only check for unique vatNumber when creating a new company
        // (cannot be changed after creation)
        if ($this->getMethod() === 'POST') {
            // TODO: check if extra validation is needed for vatNumber
            $rules['vatNumber'] = 'required|string|max:255|unique:companies';
        }

        return $rules;
    }
}
