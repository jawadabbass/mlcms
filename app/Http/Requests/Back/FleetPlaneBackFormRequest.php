<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FleetPlaneBackFormRequest extends Request
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
        $mainImage = (request()->id > 0) ? '' : 'required|';
        return [
            'fleet_category_id' => 'required',
            'plane_name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'image' => $mainImage . 'image',
            'layout_image' => 'image',
            'plane_images.*' => 'image',
            'spec_sheet' => 'mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'fleet_category_id.required' => __('Fleet Category ID is required'),
            'plane_name.required' => __('Plane Name is required'),
            'description.required' => __('Plane description required'),
            'status.required' => __('Plane Status is required'),
            'image.required' => __('Main image is required'),
            'image.image' => __('Only image can be uploaded'),
            'layout_image.image' => __('Only image can be uploaded'),
            'plane_images.*.image' => __('Only Images can be uploaded'),
            'spec_sheet.mimes' => __('Only PDF can be uploaded'),
        ];
    }
}
