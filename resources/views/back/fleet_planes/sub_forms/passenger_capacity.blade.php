@php
    use App\Models\Back\FleetPlanePassengerCapacity;
@endphp
<div class="row">
    @foreach ($passengerCapacities as $passengerCapacityObj)
        @php
            $fleetPlanePassengerCapacityObj = FleetPlanePassengerCapacity::getFleetPlanePassengerCapacity($fleetPlaneObj->id, $passengerCapacityObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $passengerCapacityObj->title }}:</label>
            <input id="passenger_capacity_value_{{ $passengerCapacityObj->id }}"
                name="passenger_capacity_value_{{ $passengerCapacityObj->id }}"
                value="{{ old('passenger_capacity_value_' . $passengerCapacityObj->id, $fleetPlanePassengerCapacityObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'passenger_capacity_value_' . $passengerCapacityObj->id) }}"
                placeholder="{{ $passengerCapacityObj->title }}">
            {!! showErrors($errors, 'passenger_capacity_value_' . $passengerCapacityObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $passengerCapacityObj->title }}:</label>
            <input id="passenger_capacity_hint_{{ $passengerCapacityObj->id }}"
                name="passenger_capacity_hint_{{ $passengerCapacityObj->id }}"
                value="{{ old('passenger_capacity_hint_' . $passengerCapacityObj->id, $fleetPlanePassengerCapacityObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'passenger_capacity_hint_' . $passengerCapacityObj->id) }}"
                placeholder="Hint for {{ $passengerCapacityObj->title }}">
            {!! showErrors($errors, 'passenger_capacity_hint_' . $passengerCapacityObj->id) !!}
        </div>
    @endforeach
</div>
