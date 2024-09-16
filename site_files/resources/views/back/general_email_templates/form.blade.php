<input type="hidden" name="id" value="{{ $generalEmailTemplateObj->id }}" />
<input type="hidden" name="dynamic_values" value="{{ $generalEmailTemplateObj->dynamic_values }}" />
<div class="col-12 mb-4">
    <label>Template Name</label>
    <input id="template_name" name="template_name" type="text" placeholder="Template Name"
        value="{{ $generalEmailTemplateObj->template_name }}"
        class="form-control {{ hasError($errors, 'template_name') }}" required>
    {!! showErrors($errors, 'template_name') !!}
    <div class="invalid-feedback">
        Please provide template name.
    </div>
</div>
<div class="col-12 mb-4">
    <label>From Name</label>
    <input id="from_name" name="from_name" type="text" placeholder="From Name"
        value="{{ $generalEmailTemplateObj->from_name }}" class="form-control {{ hasError($errors, 'from_name') }}"
        required>
    {!! showErrors($errors, 'from_name') !!}
    <div class="invalid-feedback">
        Please provide from name.
    </div>
</div>
<div class="col-12 mb-4">
    <label>From Email</label>
    <input id="from_email" name="from_email" type="text" placeholder="From Email"
        value="{{ $generalEmailTemplateObj->from_email }}" class="form-control {{ hasError($errors, 'from_email') }}"
        required>
    {!! showErrors($errors, 'from_email') !!}
    <div class="invalid-feedback">
        Please provide from email.
    </div>
</div>
<div class="col-12 mb-4">
    <label>Reply-To Name</label>
    <input id="reply_to_name" name="reply_to_name" type="text" placeholder="Reply-To Name"
        value="{{ $generalEmailTemplateObj->reply_to_name }}"
        class="form-control {{ hasError($errors, 'reply_to_name') }}" required>
    {!! showErrors($errors, 'reply_to_name') !!}
    <div class="invalid-feedback">
        Please provide reply to name.
    </div>
</div>
<div class="col-12 mb-4">
    <label>Reply-To Email</label>
    <input id="reply_to_email" name="reply_to_email" type="text" placeholder="Reply-To Email"
        value="{{ $generalEmailTemplateObj->reply_to_email }}"
        class="form-control {{ hasError($errors, 'reply_to_email') }}" required>
    {!! showErrors($errors, 'reply_to_email') !!}
    <div class="invalid-feedback">
        Please provide reply to email.
    </div>
</div>
<div class="col-12 mb-4">
    <label>Dynamic Values</label>
    <div class="row">
        <div class="col-md-12">
            @php
                $dynamicValuesArray = explode(',', $generalEmailTemplateObj->dynamic_values);
            @endphp
            @foreach ($dynamicValuesArray as $dynamicValue)
                <button type="button" class="btn btn-danger m-3" title="Click to insert in subject field"
                    onclick="putTextInCursorPlace('#subject', '{!! $dynamicValue !!}');">
                    {!! $dynamicValue !!}
                </button>
            @endforeach
        </div>
    </div>
</div>
<div class="col-12 mb-4">
    <label>Subject</label>
    <input id="subject" name="subject" type="text" placeholder="Subject"
        value="{{ $generalEmailTemplateObj->subject }}" class="form-control {{ hasError($errors, 'subject') }}"
        required>
    {!! showErrors($errors, 'subject') !!}
    <div class="invalid-feedback">
        Please provide subject.
    </div>
</div>

<div class="col-12 mb-4">
    <label>Dynamic Values</label>
    <div class="row">
        <div class="col-md-12">
            @php
                $dynamicValuesArray = explode(',', $generalEmailTemplateObj->dynamic_values);
            @endphp
            @foreach ($dynamicValuesArray as $dynamicValue)
                <button type="button" class="btn btn-primary m-3" title="Click to insert in template field"
                    onclick="putTextInCursorPlaceEditor('{!! $dynamicValue !!}');">
                    {!! $dynamicValue !!}
                </button>
            @endforeach
        </div>
    </div>
</div>
<div class="col-12 mb-4">
    <label>Email Template</label>
    <textarea id="email_template" name="email_template" type="text" placeholder="Email Template"
        class="form-control {{ hasError($errors, 'email_template') }}" required>{{ $generalEmailTemplateObj->email_template }}</textarea>
    {!! showErrors($errors, 'email_template') !!}
    <div class="invalid-feedback">
        Please provide Template.
    </div>
</div>
@push('beforeBodyClose')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('email_template');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });
    </script>
@endpush
