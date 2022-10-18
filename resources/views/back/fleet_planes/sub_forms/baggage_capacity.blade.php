@php
    use App\Models\Back\FleetPlaneBaggageCapacity;
@endphp
<div class="row">
    @foreach ($baggageCapacities as $baggageCapacityObj)
        @php
            $fleetPlaneBaggageCapacityObj = FleetPlaneBaggageCapacity::getFleetPlaneBaggageCapacity($fleetPlaneObj->id, $baggageCapacityObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $baggageCapacityObj->title }}:</label>
            <input id="baggage_capacity_value_{{ $baggageCapacityObj->id }}"
                name="baggage_capacity_value_{{ $baggageCapacityObj->id }}"
                value="{{ old('baggage_capacity_value_' . $baggageCapacityObj->id, $fleetPlaneBaggageCapacityObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'baggage_capacity_value_' . $baggageCapacityObj->id) }}"
                placeholder="{{ $baggageCapacityObj->title }}">
            {!! showErrors($errors, 'baggage_capacity_value_' . $baggageCapacityObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $baggageCapacityObj->title }}:</label>
            <input id="baggage_capacity_hint_{{ $baggageCapacityObj->id }}"
                name="baggage_capacity_hint_{{ $baggageCapacityObj->id }}"
                value="{{ old('baggage_capacity_hint_' . $baggageCapacityObj->id, $fleetPlaneBaggageCapacityObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'baggage_capacity_hint_' . $baggageCapacityObj->id) }}"
                placeholder="Hint for {{ $baggageCapacityObj->title }}">
            {!! showErrors($errors, 'baggage_capacity_hint_' . $baggageCapacityObj->id) !!}
        </div>
    @endforeach
</div>
