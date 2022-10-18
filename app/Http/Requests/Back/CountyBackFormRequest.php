<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CountyBackFormRequest extends Request
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
            'state_id' => ['required'],
            'county_name' => ['required'],                        
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => __('Please select state'),
            'county_name.required' => __('Please provide county name'),
        ];
    }
}
