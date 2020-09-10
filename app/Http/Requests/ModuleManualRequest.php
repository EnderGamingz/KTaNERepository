<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleManualRequest extends FormRequest
{
    private $acceptedTypes = ['embellished', 'reworded', 'reorganized', 'condensed', 'lookup_table', 'interactive'];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // The actuall authorization takes place in the controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'language' => 'required|string|max:25',
            'type' => ['nullable', 'string', 'max:25', Rule::in($this->acceptedTypes)],
            'files' => 'required|array',
            'files'.'*' => 'required|file|max:10000', // Maximum 10 megabyte 
        ];
    }
}
