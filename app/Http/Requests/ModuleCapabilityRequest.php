<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleCapabilityRequest extends FormRequest
{
    private $supportedCapabilities = ['mystery', 'boss', 'souvenir'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // This will allways be true because the authentfication happens in the controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
                return [
                    'type' => ['required', 'string', 'max:50', Rule::in($this->supportedCapabilities)],
                    'data' => 'required|json',
                ];
            default:
                return [
                    //
                ];
        }
    }
}
