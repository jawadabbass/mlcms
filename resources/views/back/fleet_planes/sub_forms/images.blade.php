<div class="row">
    <div class="col-lg-12 mb-3">
        <img style="border-radius: 0px;" src="{!! App\Helpers\ImageUploader::print_image_src($fleetPlaneObj->image, 'fleet_planes/thumb') !!}" id="selected_image_preview" width="200px" />
    </div>
    <div class="col-lg-12 mb-3">
        <label for="image">Main Image:*</label>
        <div class="input-group form-control {{ hasError($errors, 'image') }}">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="selected_image" name="image">
                <label class="custom-file-label"
                    for="image">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
            </div>
        </div>
        {!! showErrors($errors, 'image') !!}
    </div>
    <div class="col-lg-12 mb-3">
        <div class="row">
            @if ($fleetPlaneObj->planeImages->count() > 0)
                @foreach ($fleetPlaneObj->planeImages as $planeImage)
                    <div class="col-2 m-1" id="plane_image_{{ $planeImage->id }}">
                        <img style="border-radius: 0px;" src="{!! App\Helpers\ImageUploader::print_image_src($planeImage->image, 'fleet_planes/thumb') !!}" />
                        <div><span onclick="deletePlaneImage({{ $planeImage->id }}, '{{ $planeImage->image }}');"
                                class="text-danger" style="cursor: pointer;">Delete</span></div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="plane_images">Extra Images: (Can select more then one image)</label>
        <div class="input-group form-control {{ hasError($errors, 'plane_images') }}">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="selected_images" name="plane_images[]" multiple>
                <label class="custom-file-label"
                    for="image">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
            </div>
        </div>
        {!! showErrors($errors, 'plane_images') !!}
    </div>
    <div class="col-lg-12 mb-3">
        <div class="row" id="selected_images_preview"></div>
    </div>
    <div class="col-lg-12 mb-3">
        <img style="border-radius: 0px;" src="{!! App\Helpers\ImageUploader::print_image_src($fleetPlaneObj->layout_image, 'fleet_planes/thumb') !!}" id="selected_layout_image_preview"  width="200px"/>
    </div>
    <div class="col-lg-12 mb-3">
        <label for="layout_image">Layout Image:</label>
        <div class="input-group form-control {{ hasError($errors, 'layout_image') }}">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="selected_layout_image" name="layout_image">
                <label class="custom-file-label"
                    for="image">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
            </div>
        </div>
        {!! showErrors($errors, 'layout_image') !!}
    </div>
    @if (!empty($fleetPlaneObj->spec_sheet))
        <div class="col-lg-12 mb-3">
            <a href="{{ asset('uploads/fleet_planes/' . $fleetPlaneObj->spec_sheet) }}" target="_blank">
                <img style="border-radius: 0px;" src="{{ asset('images/pdf.png') }}" width="30px" />
            </a>
        </div>
    @endif
    <div class="col-lg-12 mb-3">
        <label for="spec_sheet">Spec Sheet:</label>
        <div class="input-group form-control {{ hasError($errors, 'spec_sheet') }}">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="selected_spec_sheet_image" name="spec_sheet">
                <label class="custom-file-label"
                    for="image">{{ 'Maximum allowed image size: ' . getMaxUploadSize() . 'MB' }}</label>
            </div>
        </div>
        {!! showErrors($errors, 'spec_sheet') !!}
    </div>
</div>
@section('beforeBodyClose')
    <script>
        function deletePlaneImage(id, image) {
        if (confirm('Are you sure?')) {
            let url = '{{ url('adminmedia/deletePlaneImageAjax/') }}';
            $.post(url, {
                    id: id,
                    image: image,
                    _token: '{{ csrf_token() }}'
                })
                .done(function(response) {
                    $('#plane_image_' + id).remove();
                });
        }
    }
    </script>
@endsection