<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BlogCategoryBackFormRequest extends Request
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
            'cate_title' => 'required',
            'cate_slug' => 'required',
            'cate_description' => 'required',
            'sts' => 'required',
            'is_featured' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cate_title.required' => __('Title is required'),
            'cate_slug.required' => __('Slug is required'),
            'cate_description.required' => __('Description is required'),
            'sts.required' => __('Status is required'),
            'is_featured.required' => __('Is Featured?'),
        ];
    }
}
