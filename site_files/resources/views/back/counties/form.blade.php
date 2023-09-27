<input type="hidden" name="id" value="{{ $countyObj->id }}" />
<div class="col-12 mb-4">
    <label>State</label>
    <select class="form-control select2" name="state_id" id="state_id">
        {!! generateStatesDropDown($countyObj->state_id, true) !!}
    </select>
</div>

<div class="col-12 mb-4">
    <label>County Name</label>
    <input id="county_name" name="county_name" type="text" placeholder="County Name"
        value="{{ $countyObj->county_name }}" class="form-control">
</div>

<div class="col-12 mb-4">
    <label>County Status</label>
    <select class="form-control" name="status">
        {!! generateStatusDropDown($countyObj->status, false) !!}
    </select>
</div>
