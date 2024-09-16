<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class GeneralEmailTemplateBackFormRequest extends Request
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

    public function __construct()
    {
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dynamic_values' => ['required'],
            'from_name' => ['required'],
            'from_email' => ['required'],
            'reply_to_name' => ['required'],
            'reply_to_email' => ['required'],
            'subject' => ['required', Rule::unique('general_email_templates', 'subject')->ignore(request()->id, 'id')],            
            'template_name' => ['required', Rule::unique('general_email_templates', 'template_name')->ignore(request()->id, 'id')],            
            'email_template' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'dunamic_values.required' => __('Please provide dunamic values'),
            'from_name.required' => __('Please provide from name'),
            'from_email.required' => __('Please provide from email'),
            'reply_to_name.required' => __('Please provide reply-to name'),
            'reply_to_email.required' => __('Please provide reply-to email'),
            'subject.required' => __('Please provide subject'),
            'subject.unique' => __('Subject already used'),
            'template_name.required' => __('Please provide template name'),
            'template_name.unique' => __('Template name already used'),            
            'email_template.required' => __('Please provide email template'),
        ];
    }
}
