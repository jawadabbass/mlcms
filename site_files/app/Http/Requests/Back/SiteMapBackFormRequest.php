<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SiteMapBackFormRequest extends Request
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
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Please provide Site Map title'),
        ];
    }
}
