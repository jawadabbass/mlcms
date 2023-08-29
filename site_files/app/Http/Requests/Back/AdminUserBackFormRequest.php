<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AdminUserBackFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function __construct()
    {
        //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $password_required = ((int) request()->id > 0) ? 'nullable' : 'required';
        return [
            'admin_name' => [
                'required',
                Rule::unique('users', 'name')->ignore(request()->id, 'id'),
            ],
            'admin_email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(request()->id, 'id'),
            ],
            'password' => [
                $password_required,
                'string',
                'min:8',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'type' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'admin_name.required' => 'Please provide name.',
            'admin_email.required' => 'Please provide e-mail address.',
            'admin_email.email' => 'Please provide valid e-mail address.',
            'admin_email.unique' => 'E-mail address already exists.',
            'password.required' => 'Please provide password.',
            'password.regex' => 'Password must be 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character',
            'type.required' => 'User type required',
        ];
    }
}
