<?php

namespace App\Http\Requests\Back;

use App\Http\Requests\Request;

class LeadStatUrlBackFormRequest extends Request
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
        $rules = [
            'url' => 'required',
            'url_internal_external' => 'required',
        ];
        if (request('url_internal_external') == 'internal') {
            $rules['final_destination'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'url.required' => __('URL is required'),
            'url_internal_external.required' => __('Is URL Internal/External'),
            'final_destination.required' => __('Final destination is required'),
        ];
    }
}
