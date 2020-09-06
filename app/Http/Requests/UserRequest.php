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
        return [];
    }
}
