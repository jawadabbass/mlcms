@php
    use App\Models\Back\FleetPlaneSafety;
@endphp
<div class="row">
    @foreach ($safeties as $safetyObj)
        @php
            $fleetPlaneSafetyObj = FleetPlaneSafety::getFleetPlaneSafety($fleetPlaneObj->id, $safetyObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $safetyObj->title }}:</label>
            <input id="safety_value_{{ $safetyObj->id }}"
                name="safety_value_{{ $safetyObj->id }}"
                value="{{ old('safety_value_' . $safetyObj->id, $fleetPlaneSafetyObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'safety_value_' . $safetyObj->id) }}"
                placeholder="{{ $safetyObj->title }}">
            {!! showErrors($errors, 'safety_value_' . $safetyObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $safetyObj->title }}:</label>
            <input id="safety_hint_{{ $safetyObj->id }}"
                name="safety_hint_{{ $safetyObj->id }}"
                value="{{ old('safety_hint_' . $safetyObj->id, $fleetPlaneSafetyObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'safety_hint_' . $safetyObj->id) }}"
                placeholder="Hint for {{ $safetyObj->title }}">
            {!! showErrors($errors, 'safety_hint_' . $safetyObj->id) !!}
        </div>
    @endforeach
</div>