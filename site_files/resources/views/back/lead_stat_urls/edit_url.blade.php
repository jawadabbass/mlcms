<form name="updateLeadStatUrlFrm" id="updateLeadStatUrlFrm" method="POST" action="{{ route('updateLeadStatUrl') }}">
    <input type="hidden" value="{{ $leadStatUrlObj->id }}" name="id">
    @csrf
    @include('back.lead_stat_urls.edit_url_common_fields')
    <div class="col-md-12 mb-3 text-right">
        <button type="button" name="" onclick="updateLeadStatUrl();" class="btn btn-primary">Update</button>
    </div>
</form>
