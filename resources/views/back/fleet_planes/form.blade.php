<input type="hidden" name="id" value="{{ $fleetPlaneObj->id }}" />
<div class="col-lg-12 p-3">
    <ul class="nav nav-tabs" id="fleetPlaneTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="fleetPlane-detail-tab" data-bs-toggle="tab" href="#fleetPlane-detail" role="tab"
                aria-controls="fleetPlane-detail" aria-selected="true">Details</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-images-tab" data-bs-toggle="tab" href="#fleetPlane-images" role="tab"
                aria-controls="fleetPlane-images" aria-selected="false">Images</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-passenger-capacity-tab" data-bs-toggle="tab" href="#fleetPlane-passenger-capacity" role="tab"
                aria-controls="fleetPlane-passenger-capacity" aria-selected="false">Passenger Capacity</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-cabin-dimensions-tab" data-bs-toggle="tab" href="#fleetPlane-cabin-dimensions" role="tab"
                aria-controls="fleetPlane-cabin-dimensions" aria-selected="false">Cabin Dimensions</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-baggage-capacity-tab" data-bs-toggle="tab" href="#fleetPlane-baggage-capacity" role="tab"
                aria-controls="fleetPlane-baggage-capacity" aria-selected="false">Baggage Capacity</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-performance-tab" data-bs-toggle="tab" href="#fleetPlane-performance" role="tab"
                aria-controls="fleetPlane-performance" aria-selected="false">Performance</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-cabin-amenities-tab" data-bs-toggle="tab" href="#fleetPlane-cabin-amenities" role="tab"
                aria-controls="fleetPlane-cabin-amenities" aria-selected="false">Cabin Amenities</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="fleetPlane-safety-tab" data-bs-toggle="tab" href="#fleetPlane-safety" role="tab"
                aria-controls="fleetPlane-safety" aria-selected="false">Safety</a>
        </li>
    </ul>
    <div class="tab-content p-3" id="fleetPlaneTabsContent">
        <div class="tab-pane fade show active" id="fleetPlane-detail" role="tabpanel"
            aria-labelledby="fleetPlane-detail-tab">
            @include('back.fleet_planes.sub_forms.details')
        </div>
        <div class="tab-pane fade" id="fleetPlane-images" role="tabpanel"
            aria-labelledby="fleetPlane-images-tab">
            @include('back.fleet_planes.sub_forms.images')
        </div>
        <div class="tab-pane fade" id="fleetPlane-passenger-capacity" role="tabpanel"
            aria-labelledby="fleetPlane-passenger-capacity-tab">
            @include('back.fleet_planes.sub_forms.passenger_capacity')
        </div>
        <div class="tab-pane fade" id="fleetPlane-cabin-dimensions" role="tabpanel"
            aria-labelledby="fleetPlane-cabin-dimensions-tab">
            @include('back.fleet_planes.sub_forms.cabin_dimensions')
        </div>
        <div class="tab-pane fade" id="fleetPlane-baggage-capacity" role="tabpanel"
            aria-labelledby="fleetPlane-baggage-capacity-tab">
            @include('back.fleet_planes.sub_forms.baggage_capacity')
        </div>
        <div class="tab-pane fade" id="fleetPlane-performance" role="tabpanel"
            aria-labelledby="fleetPlane-performance-tab">
            @include('back.fleet_planes.sub_forms.performance')
        </div>
        <div class="tab-pane fade" id="fleetPlane-cabin-amenities" role="tabpanel"
            aria-labelledby="fleetPlane-cabin-amenities-tab">
            @include('back.fleet_planes.sub_forms.cabin_amenities')
        </div>
        <div class="tab-pane fade" id="fleetPlane-safety" role="tabpanel"
            aria-labelledby="fleetPlane-safety-tab">
            @include('back.fleet_planes.sub_forms.safety')
        </div>
    </div>
</div>
@section('beforeBodyClose')
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description');
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        });
    </script>
@endsection
