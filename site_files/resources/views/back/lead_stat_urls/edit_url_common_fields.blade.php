<div class="col-md-12 mb-3">
    <label class="form-label">Internal or External?:*</label>
    <select id="url_internal_external" name="url_internal_external"
        class="form-control {{ hasError($errors, 'url_internal_external') }}"
        onchange="adjust_URL_Keyword(this.value);">
        {!! generateLeadStatUrlInternalExternalDropDown(
            old('url_internal_external', $leadStatUrlObj->url_internal_external),
            false,
        ) !!}
    </select>
    {!! showErrors($errors, 'url_internal_external') !!}
</div>
<div class="col-md-12 mb-3" id="url_div">
    @if (old('url_internal_external', $leadStatUrlObj->url_internal_external) == 'internal')
        <label class="form-label">URL:*</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    {{ config('Constants.REF_URL') }}
                </span>
            </div>
            <input id="url" name="url" value="{{ old('url', $leadStatUrlObj->url) }}" type="text"
                class="form-control {{ hasError($errors, 'url') }}" placeholder="URL" aria-describedby="url">
        </div>
        {!! showErrors($errors, 'url') !!}
    @else
        <label class="form-label">Keyword:*</label>
        <input id="url" name="url" value="{{ old('url', $leadStatUrlObj->url) }}" type="text"
            class="form-control {{ hasError($errors, 'url') }}" placeholder="Keyword" aria-describedby="url">
        {!! showErrors($errors, 'url') !!}
    @endif
</div>
@push('beforeBodyClose')
    @include('back.lead_stat_urls.edit_url_js')
@endpush
