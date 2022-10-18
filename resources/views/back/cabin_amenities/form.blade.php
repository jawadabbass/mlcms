<input type="hidden" value="{{$cabinAmenityObj->id}}" name="id">
<div class="col-md-12 mb-3">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $cabinAmenityObj->title) }}"
        type="text" class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Status</label>
    <select class="form-control" name="status" id="status">
        {!! generateCabinAmenitiesStatusDropDown($cabinAmenityObj->status, false) !!}
    </select>
</div>