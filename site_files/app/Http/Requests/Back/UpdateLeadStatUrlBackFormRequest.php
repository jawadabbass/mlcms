<?php

namespace App\Http\Requests\Back;

use App\Http\Requests\Request;

class UpdateLeadStatUrlBackFormRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'url.required' => __('URL is required'),
        ];
    }
}
