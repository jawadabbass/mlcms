<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FleetCategoryBackFormRequest extends Request
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
        $imageRules = ((bool)request()->id === false) ? 'required|' : '';
        return [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => $imageRules . 'image',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Name is required'),
            'description.required' => __('Description is required'),
            'status.required' => __('Status is required'),
            'image.required' => __('Logo is required'),
            'image.image' => __('Only Image can be uploaded'),
        ];
    }
}
