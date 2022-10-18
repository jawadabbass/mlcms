<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CityBackFormRequest extends Request
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
            'county_id' => ['required'],
            'city_name' => ['required'],                        
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => __('Please select state'),
            'county_id.required' => __('Please select county'),
            'city_name.required' => __('Please provide city name'),
        ];
    }
}
