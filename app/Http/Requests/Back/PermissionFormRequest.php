<?php

namespace App\Http\Requests\Back;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PermissionFormRequest extends FormRequest
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
                Rule::unique('permissions', 'title')->ignore(request()->id),
            ],
            "permission_group_id" => "required",
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Permission title is required',
            'title.unique' => 'Permission already exist',
            'permission_group_id.required' => 'Please select permission group',
        ];
    }

}
