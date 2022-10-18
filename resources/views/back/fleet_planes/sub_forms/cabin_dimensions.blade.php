@php
    use App\Models\Back\FleetPlaneCabinDimension;
@endphp
<div class="row">
    @foreach ($cabinDimensions as $cabinDimensionObj)
        @php
            $fleetPlaneCabinDimensionObj = FleetPlaneCabinDimension::getFleetPlaneCabinDimension($fleetPlaneObj->id, $cabinDimensionObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $cabinDimensionObj->title }}:</label>
            <input id="cabin_dimension_value_{{ $cabinDimensionObj->id }}"
                name="cabin_dimension_value_{{ $cabinDimensionObj->id }}"
                value="{{ old('cabin_dimension_value_' . $cabinDimensionObj->id, $fleetPlaneCabinDimensionObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'cabin_dimension_value_' . $cabinDimensionObj->id) }}"
                placeholder="{{ $cabinDimensionObj->title }}">
            {!! showErrors($errors, 'cabin_dimension_value_' . $cabinDimensionObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $cabinDimensionObj->title }}:</label>
            <input id="cabin_dimension_hint_{{ $cabinDimensionObj->id }}"
                name="cabin_dimension_hint_{{ $cabinDimensionObj->id }}"
                value="{{ old('cabin_dimension_hint_' . $cabinDimensionObj->id, $fleetPlaneCabinDimensionObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'cabin_dimension_hint_' . $cabinDimensionObj->id) }}"
                placeholder="Hint for {{ $cabinDimensionObj->title }}">
            {!! showErrors($errors, 'cabin_dimension_hint_' . $cabinDimensionObj->id) !!}
        </div>
    @endforeach
</div>
