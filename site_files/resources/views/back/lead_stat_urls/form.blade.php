<input type="hidden" value="{{ $leadStatUrlObj->id }}" name="id">
<div class="col-md-12 mb-3 text-right">
    <a href="{{ route('leadStatUrls.index') }}" class="btn btn-small btn-primary">
        <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
    </a>
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Referrer:*</label>
    <input id="referrer" name="referrer" value="{{ old('referrer', $leadStatUrlObj->referrer) }}" type="text"
        class="form-control {{ hasError($errors, 'referrer') }}" placeholder="Referrer">
    {!! showErrors($errors, 'referrer') !!}
</div>
@include('back.lead_stat_urls.edit_url_common_fields')
