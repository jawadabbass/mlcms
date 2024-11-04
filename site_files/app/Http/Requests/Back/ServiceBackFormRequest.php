<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ServiceBackFormRequest extends Request
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

    public function __construct() {}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $maxImageSize = getMaxUploadSize() * 1024;
        return [
            'title' => ['required'],
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:' . $maxImageSize,
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Please provide Service title'),
            'featured_image.image' => 'Featured image must be an image.',
            'featured_image.mimes' => 'Featured image must be of type jpeg,png,jpg,gif,webp.',

        ];
    }
}
