<input type="hidden" value="{{$performanceObj->id}}" name="id">
<div class="col-md-12 mb-3">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $performanceObj->title) }}"
        type="text" class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Status</label>
    <select class="form-control" name="status" id="status">
        {!! generatePerformancesStatusDropDown($performanceObj->status, false) !!}
    </select>
</div>