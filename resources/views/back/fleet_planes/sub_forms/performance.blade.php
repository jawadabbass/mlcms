@php
    use App\Models\Back\FleetPlanePerformance;
@endphp
<div class="row">
    @foreach ($performances as $performanceObj)
        @php
            $fleetPlanePerformanceObj = FleetPlanePerformance::getFleetPlanePerformance($fleetPlaneObj->id, $performanceObj->id);
        @endphp
        <div class="col-lg-6 mb-3">
            <label class="form-label">{{ $performanceObj->title }}:</label>
            <input id="performance_value_{{ $performanceObj->id }}"
                name="performance_value_{{ $performanceObj->id }}"
                value="{{ old('performance_value_' . $performanceObj->id, $fleetPlanePerformanceObj->value) }}"
                type="text"
                class="form-control {{ hasError($errors, 'performance_value_' . $performanceObj->id) }}"
                placeholder="{{ $performanceObj->title }}">
            {!! showErrors($errors, 'performance_value_' . $performanceObj->id) !!}
        </div>
        <div class="col-lg-6 mb-3">
            <label class="form-label">Hint for {{ $performanceObj->title }}:</label>
            <input id="performance_hint_{{ $performanceObj->id }}"
                name="performance_hint_{{ $performanceObj->id }}"
                value="{{ old('performance_hint_' . $performanceObj->id, $fleetPlanePerformanceObj->hint) }}"
                type="text"
                class="form-control {{ hasError($errors, 'performance_hint_' . $performanceObj->id) }}"
                placeholder="Hint for {{ $performanceObj->title }}">
            {!! showErrors($errors, 'performance_hint_' . $performanceObj->id) !!}
        </div>
    @endforeach
</div>