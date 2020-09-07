<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = null;
        switch($this->route()->getName()) {
            case 'admin.modules.index':
                $permission = 'view.admin.modules';
                break;
        }

        return $this->user()->hasPermission($permission);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->route()->getName()) {
            case 'admin.modules.store':
            case 'modules.store':
                return [
                    'name' => 'required|string|max:100',
                    'description' => 'required|string|max:255',
                    'credits' => 'nullable|array',
                    'credits.*' => 'string|max:50',
                    'expert_difficulty' => 'required|integer|between:1,100',
                    'defuser_difficulty' => 'required|integer|between:1,100',
                    'metadata' => 'nullable|array',
                    'metadata.*' => 'string',
                    'tags' => 'nullable|array',
                    'tags.*' => 'string|max:50',
                ];
            default: 
                return [
                    //
                ];
        }
    }
}
