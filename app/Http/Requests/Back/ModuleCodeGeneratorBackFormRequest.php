<?php

namespace App\Http\Requests\Back;

use Auth;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ModuleCodeGeneratorBackFormRequest extends Request
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
            'field_name.*' => 'required',
            'field_label.*' => 'required',
            'MODEL_NAME_STUB' => 'required',
            'MODEL_NAME_PLURAL_STUB' => 'required',
            'MODEL_NAME_WITH_SPACE_STUB' => 'required',
            'MODEL_NAME_PLURAL_WITH_SPACE_STUB' => 'required',
            'MODEL_NAME_COLLECTION_STUB' => 'required',
            'CONTROLLER_NAME_STUB' => 'required',
            'ADMIN_RESOURCES_STUB' => 'required',
            'OBJECT_NAME_STUB' => 'required',
            'DB_TABLE_NAME_STUB' => 'required',
            'MAIN_FIELD_TITLE_OR_NAME_STUB' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'field_name.*.required' => __('Field Name is required'),
            'field_label.*.required' => __('Field Label is required'),
            'MODEL_NAME_STUB.required' => __('Model Name is required'),
            'MODEL_NAME_PLURAL_STUB.required' => __('Model Name Plural is required'),
            'MODEL_NAME_WITH_SPACE_STUB.required' => __('Model Name With Space is required'),
            'MODEL_NAME_PLURAL_WITH_SPACE_STUB.required' => __('Model Name Plural With Space is required'),
            'MODEL_NAME_COLLECTION_STUB.required' => __('Model Name Collection is required'),
            'CONTROLLER_NAME_STUB.required' => __('Controller Name is required'),
            'ADMIN_RESOURCES_STUB.required' => __('Admin Resources Folder Name is required'),
            'OBJECT_NAME_STUB.required' => __('Object Name is required'),
            'DB_TABLE_NAME_STUB.required' => __('DB Table Name is required'),
            'MAIN_FIELD_TITLE_OR_NAME_STUB.required' => __('Main Field i.e TITLE or NAME is required'),
        ];
    }
}