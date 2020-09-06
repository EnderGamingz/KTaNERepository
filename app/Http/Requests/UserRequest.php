<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case 'admin.users.index':
                $permission = 'view.admin.users';
                break;
            case 'admin.users.show':
                $permission = 'show.admin.users';
                break;
            case 'admin.users.permissions':
                $permission = 'permissions.admin.users';
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
            case 'admin.users.permissions':
                return [
                    'permissions' => 'nullable|array',
                    'permissions.*' => 'required|integer|exists:permissions,id',
                    'roles' => 'nullable|array',
                    'roles.*' => 'required|integer|exists:roles,id',
                ];
            default:
                return [];
        }
    }
}
