<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
class ModuleRequest extends FormRequest
{
    const $scopes = ['capability'];
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
            // NOTE: This will not fully authorize the request due to the fact we are using a 
            // policy to check if the user has access to it which will happen in the controller.
            case 'modules.update':
                return $this->user() && $this->update_scope;
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
                    'links' => 'nullable|array',
                    'links.*' => 'url',
                ];
            case 'modules.update':
                // Check if the update scope is valid
                if(!in_array($this->update_scope, $scopes)) {
                    abort(403, 'Scope is not supported');
                    return;
                }

                // Check if the update scope is capability
                if($this->update_scope == 'capability') {
                    // Returns validations for the capability update scope
                    return [
                        'type' => ['required', 'string', 'max:50', Rule::in(['mystery', 'boss'])],
                        'data' => 'required|json',
                    ];
                }
            default: 
                return [
                    //
                ];
        }
    }
}
