<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CareerBackFormRequest extends Request
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
            'title' => 'required',
            'description' => 'required',
            'apply_by_date_time' => 'required',
            'location' => 'required',
            'type' => 'required',
            'benefits' => 'required',
            'status' => 'required',
            'pdf_doc' => 'nullable|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Name is required'),
            'description.required' => __('Description is required'),
            'apply_by_date_time.required' => __('Date is required'),
            'location.required' => __('Location is required'),
            'type.required' => __('Type is required'),
            'benefits.required' => __('Benefits required'),
            'status.required' => __('Status is required'),
            'pdf_doc.mimes' => __('Only PDF can be uploaded'),
        ];
    }
}
