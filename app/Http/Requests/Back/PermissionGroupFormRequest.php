<?php

namespace App\Http\Requests\Back;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PermissionGroupFormRequest extends FormRequest
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
                Rule::unique('permissions_group', 'title')->ignore(request()->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'PermissionGroup title is required',
            'title.unique' => 'PermissionGroup already exist',
        ];
    }
}
