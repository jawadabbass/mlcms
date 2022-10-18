<input type="hidden" name="id" value="{{ $cityObj->id }}" />

<div class="col-12 mb-4">
    <label>State</label>
    <select class="form-control select2 {{ hasError($errors, 'state_id') }}" name="state_id" id="state_id" onchange="filterCountiesAjax();">
        {!! generateStatesDropDown($cityObj->state_id, true) !!}
    </select>
    {!! showErrors($errors, 'state_id') !!}
</div>

<div class="col-12 mb-4" id="counties_dd_div">
    <label>County</label>
    <select class="form-control select2 {{ hasError($errors, 'county_id') }}" name="county_id" id="county_id">
        {!! generateCountiesDropDown($cityObj->county_id, $cityObj->state_id, true) !!}
    </select>
    {!! showErrors($errors, 'county_id') !!}
</div>

<div class="col-12 mb-4">
    <label>City Name</label>
    <input id="city_name" name="city_name" type="text" placeholder="City Name" value="{{ $cityObj->city_name }}"
        class="form-control select2 {{ hasError($errors, 'city_name') }}">
        {!! showErrors($errors, 'city_name') !!}
</div>

<div class="col-12 mb-4">
    <label>City Status</label>
    <select class="form-control" name="status">
        {!! generateStatusDropDown($cityObj->status, false) !!}
    </select>
</div>