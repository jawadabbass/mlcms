<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label">Job Title:</label>
        <input value="{{ $careerObj->title }}" type="text" class="form-control" disabled>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Dated:</label>
        <input value="{{ date('m-d-Y', strtotime($jobApplicationObj->created_at)) }}" type="text" class="form-control"
            disabled>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Applicant Name:</label>
        <input value="{{ $jobApplicationObj->name }}" type="text" class="form-control" disabled>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Applicant Email:</label>
        <input value="{{ $jobApplicationObj->email }}" type="text" class="form-control" disabled>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Applicant Phone:</label>
        <input value="{{ $jobApplicationObj->phone }}" type="text" class="form-control" disabled>
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">Applicant Message:</label>
        <textarea class="form-control" disabled>{{ $jobApplicationObj->comments }}</textarea>
    </div>

</div>
