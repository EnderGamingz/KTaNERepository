<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permission = null;

        switch($this->method()) {
            case 'GET':
                $permission = 'show.admin.roles';
                break;
            case 'POST':
                $permission = 'create.admin.roles';
                break;
            case 'PATCH':
                $permission = 'edit.admin.roles';
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
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:50|unique:roles,name',
                    'description' => 'nullable|string|max:255',
                    'permissions' => 'nullable|array',
                    'permissions.*' => 'required|integer|exists:permissions,id',
                ];
            case 'PATCH': 
                return [
                    'name' => 'required|string|max:50|unique:roles,name,' . $this->role->id,
                    'description' => 'nullable|string|max:255',
                    'permissions' => 'nullable|array',
                    'permissions.*' => 'required|integer|exists:permissions,id',
                ];
            default:
                return [];
        }
    }
}
