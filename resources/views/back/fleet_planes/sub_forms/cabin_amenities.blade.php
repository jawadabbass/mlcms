@php
    use App\Models\Back\FleetPlaneCabinAmenity;
@endphp
<div class="row">
    @foreach ($cabinAmenities as $cabinAmenityObj)
        @php
            $fleetPlaneCabinAmenityObj = FleetPlaneCabinAmenity::getFleetPlaneCabinAmenity($fleetPlaneObj->id, $cabinAmenityObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $cabinAmenityObj->title }}:</label>
            <input id="cabin_amenity_value_{{ $cabinAmenityObj->id }}"
                name="cabin_amenity_value_{{ $cabinAmenityObj->id }}"
                value="{{ old('cabin_amenity_value_' . $cabinAmenityObj->id, $fleetPlaneCabinAmenityObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'cabin_amenity_value_' . $cabinAmenityObj->id) }}"
                placeholder="{{ $cabinAmenityObj->title }}">
            {!! showErrors($errors, 'cabin_amenity_value_' . $cabinAmenityObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $cabinAmenityObj->title }}:</label>
            <input id="cabin_amenity_hint_{{ $cabinAmenityObj->id }}"
                name="cabin_amenity_hint_{{ $cabinAmenityObj->id }}"
                value="{{ old('cabin_amenity_hint_' . $cabinAmenityObj->id, $fleetPlaneCabinAmenityObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'cabin_amenity_hint_' . $cabinAmenityObj->id) }}"
                placeholder="Hint for {{ $cabinAmenityObj->title }}">
            {!! showErrors($errors, 'cabin_amenity_hint_' . $cabinAmenityObj->id) !!}
        </div>
    @endforeach
</div>