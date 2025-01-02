<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class BlogPostFeaturedImageBackFormRequest extends Request
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
            'featured_img' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'featured_img.image' => __('Only Image can be uploaded'),
        ];
    }
}
