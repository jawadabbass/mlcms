<?php

namespace App\Traits;

trait GeneralEmailTemplateTrait
{

    private function setGeneralEmailTemplateValues($request, $generalEmailTemplateObj)
    {
        $generalEmailTemplateObj->dynamic_values = $request->input('dynamic_values');
        $generalEmailTemplateObj->template_name = $request->input('template_name');
        $generalEmailTemplateObj->from_name = $request->input('from_name');
        $generalEmailTemplateObj->from_email = $request->input('from_email');
        $generalEmailTemplateObj->reply_to_name = $request->input('reply_to_name');
        $generalEmailTemplateObj->reply_to_email = $request->input('reply_to_email');
        $generalEmailTemplateObj->subject = $request->input('subject');
        $generalEmailTemplateObj->email_template = $request->input('email_template');
        $generalEmailTemplateObj->is_temporary = 0;
        return $generalEmailTemplateObj;
    }

}
