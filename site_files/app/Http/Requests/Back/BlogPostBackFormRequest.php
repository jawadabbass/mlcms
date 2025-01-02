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
            'author_id' => 'required',
            'author_name' => 'required',
            'title' => 'required',
            'post_slug' => 'required',
            'description' => 'required',
            'dated' => 'required',
            'sts' => 'required',
            'is_featured' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'author_id.required' => __('Author ID is required'),
            'author_name.required' => __('Author Name is required'),
            'title.required' => __('Title is required'),
            'post_slug.required' => __('Slug is required'),
            'description.required' => __('Description is required'),
            'dated.required' => __('Date is required'),
            'sts.required' => __('Status is required'),
            'is_featured.required' => __('Is Featured?'),
        ];
    }
}
