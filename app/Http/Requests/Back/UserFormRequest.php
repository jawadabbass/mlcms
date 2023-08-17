<?php

namespace App\Http\Requests\Back;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::check()) ? true : false;
    }

    public function rules()
    {
        $rulesArray = [
            "name" => "required",
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                Rule::unique('users', 'email')->ignore(request()->id),
            ],
        ];

        if(empty(request()->id) || !empty(request()->password)){
            $rulesArray["password"] = [
                "required",
                "string",
                "min:6",             // must be at least 6 characters in length
                "regex:/[a-z]/",      // must contain at least one lowercase letter
                "regex:/[A-Z]/",      // must contain at least one uppercase letter
                "regex:/[0-9]/",      // must contain at least one digit
                "regex:/[@$!%*#?&]/", // must contain a special character
            ];
        }
        return $rulesArray;
    }
    public function messages()
    {
        return [
            "name.required" => "User name is required",
            'name.unique' => 'User name already exist',
            'email.required' => 'Please provide e-mail address!',
            'email.email' => 'Please provide valid e-mail address!',
            'password.required' => 'Please provide password!',
            'password.confirmed' => 'Passwords must match...',
            'password.regex' => 'Password must be 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character',
        ];
    }
}
