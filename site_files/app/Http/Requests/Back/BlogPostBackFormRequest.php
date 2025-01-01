<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BlogPostBackFormRequest extends Request
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
            'post_slug' => 'required',
            'description' => 'required',
            'dated' => 'required',
            'sts' => 'required',
            'featured_img' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Title is required'),
            'post_slug.required' => __('Slug is required'),
            'description.required' => __('Description is required'),
            'dated.required' => __('Date is required'),
            'sts.required' => __('Status is required'),
            'featured_img.required' => __('Image is required'),
            'featured_img.image' => __('Only Image can be uploaded'),
        ];
    }
}
