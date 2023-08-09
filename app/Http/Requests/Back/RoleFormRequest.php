<?php

namespace App\Http\Requests\Back;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::check())? true:false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => [
                "required",
                Rule::unique('roles', 'title')->ignore(request()->id),
            ],
            "permission_ids" => "required",
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Role title is required',
            'title.unique' => 'Role already exist',
            "permission_ids.required" => "Please select Permissions",
        ];
    }
}
