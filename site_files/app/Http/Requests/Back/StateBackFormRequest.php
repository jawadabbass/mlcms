<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StateBackFormRequest extends Request
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
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state_code' => [
                'required',
                Rule::unique('states', 'state_code')->ignore(request()->id, 'id'),
            ],
            'state_name' => [
                'required',
                Rule::unique('states', 'state_name')->ignore(request()->id, 'id'),
            ],
                        
        ];
    }

    public function messages()
    {
        return [
            'state_code.required' => __('Please provide state code'),
            'state_code.unique' => __('State code already exist'),
            'state_name.required' => __('Please provide state name'),
            'state_name.unique' => __('State name already exist'),
        ];
    }
}
