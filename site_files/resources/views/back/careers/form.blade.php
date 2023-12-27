<input type="hidden" value="{{ $careerObj->id }}" name="id">
<div class="col-md-12 mb-3">
    <label class="form-label">Title:*</label>
    <input id="title" name="title" value="{{ old('title', $careerObj->title) }}" type="text"
        class="form-control {{ hasError($errors, 'title') }}" placeholder="Title">
    {!! showErrors($errors, 'title') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Description:*</label>
    <textarea name="description" id="description" class="form-control {{ hasError($errors, 'description') }}"
        placeholder="Description">{{ old('description', $careerObj->description) }}</textarea>
    {!! showErrors($errors, 'description') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Apply by date:*</label>
    <input id="apply_by_date_time" name="apply_by_date_time"
        value="{{ old('apply_by_date_time', $careerObj->apply_by_date_time) }}" type="text"
        class="form-control {{ hasError($errors, 'apply_by_date_time') }}" placeholder="Apply by date">
    {!! showErrors($errors, 'apply_by_date_time') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Location:*</label>
    <input id="location" name="location" value="{{ old('location', $careerObj->location) }}" type="text"
        class="form-control {{ hasError($errors, 'location') }}" placeholder="Location">
    {!! showErrors($errors, 'location') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Type:*</label>
    <select id="type" name="type" class="form-control {{ hasError($errors, 'type') }}" placeholder="Type">
        <option value="">Select...</option>
        <option value="Full Time" {{ old('type', $careerObj->type) == 'Full Time' ? 'selected' : '' }}>Full Time
        </option>
        <option value="Part Time" {{ old('type', $careerObj->type) == 'Part Time' ? 'selected' : '' }}>Part Time
        </option>
    </select>
    {!! showErrors($errors, 'type') !!}
</div>
<div class="col-md-12 mb-3">
    <label class="form-label">Benefits:*</label>
    <div class="row" id="benefits_div">
        @php
            $counter = 1;
        @endphp
        @foreach ($careerObj->benefits as $benefitObj)
            <div class="col-md-10 mb-2 cls_{{ $counter }}">
                <input type="text" name="benefits[]" class="form-control" value="{{ $benefitObj->title }}" />
            </div>
            @if ($counter > 1)
                <div class="col-md-2 mb-2 cls_{{ $counter }}">
                    <button type="button" class="btn btn-danger"
                        onclick="removeBenefitRow({{ $counter }});">Remove</button>
                </div>
            @endif
            @php
                $counter++;
            @endphp
        @endforeach

    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-warning" onclick="addBenefitRow();">Add Benefit</button>
        </div>
    </div>
    <input type="hidden" value="{{ $counter }}" name="benefit_id" id="benefit_id">
    {!! showErrors($errors, 'benefits') !!}
</div>
<div class="col-md-12 mb-3">
    <label>Status:*</label>
    <select class="form-control" name="status" id="status">
        {!! generateCareerStatusDropDown($careerObj->status, false) !!}
    </select>
</div>

@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            $("#apply_by_date_time").datepicker({
                format: 'Y-m-d'
            });
        });

        function addBenefitRow() {
            let id = $('#benefit_id').val();
            id = Number(id) + 1;
            $('#benefit_id').val(id);
            $('#benefits_div').append(`
            <div class="col-md-10 mb-2 cls_${id}">
                <input type="text" name="benefits[]" class="form-control" />
            </div>
            <div class="col-md-2 mb-2 cls_${id}">
                <button type="button" class="btn btn-danger" onclick="removeBenefitRow(${id});">Remove</button>
            </div>`);
        }

        function removeBenefitRow(cls) {
            $('.cls_' + cls).remove();
        }
    </script>
@endsection
