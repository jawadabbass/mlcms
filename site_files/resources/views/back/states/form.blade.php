<input type="hidden" name="id" value="{{ $stateObj->id }}" />
<div class="col-12 mb-4">
    <label>State Code</label>
    <input id="state_code" name="state_code" type="text" placeholder="State Code" value="{{ $stateObj->state_code }}"
        class="form-control">
</div>

<div class="col-12 mb-4">
    <label>State Name</label>
    <input id="state_name" name="state_name" type="text" placeholder="State Name" value="{{ $stateObj->state_name }}"
        class="form-control">
</div>

<div class="col-12 mb-4">
    <label>State Status</label>
    <select class="form-control" name="status">
    {!! generateStatusDropDown($stateObj->status, false) !!}
    </select>
</div>