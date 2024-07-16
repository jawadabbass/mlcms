<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class NewsBackFormRequest extends Request
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
            'news_date_time' => 'required',
            'has_registration_link' => 'required',
            'registration_link' => 'required_if:has_registration_link,1',
            'is_hide_event_after_date' => 'required',
            'is_featured' => 'required',
            'is_third_party_link' => 'required',
            'news_link' => 'required_if:is_third_party_link,1',
            'status' => 'required',
            'image' => $imageRules . 'image',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('Name is required'),
            'description.required' => __('Description is required'),
            'news_date_time.required' => __('Date is required'),
            'has_registration_link.required' => __('Has registration link?'),
            'registration_link.required_if' => __('Registration link required'),
            'is_hide_event_after_date.required' => __('Is hide event after date'),
            'is_featured.required' => __('Is Featured'),
            'is_third_party_link.required' => __('Is third party link?'),
            'news_link.required_if' => __('News link required'),
            'status.required' => __('Status is required'),
            'image.required' => __('Image is required'),
            'image.image' => __('Only Image can be uploaded'),
        ];
    }
}
