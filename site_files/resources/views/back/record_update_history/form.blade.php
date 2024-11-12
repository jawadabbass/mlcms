<div class="form-group">
    <label>Details:</label>
    <p>
        Model / Table : <strong>{{ $recordUpdateHistoryObj->model_or_table }}</strong>
    </p>
    @php
        $draftArray = json_decode($recordUpdateHistoryObj->draft);
    @endphp

    @foreach ($draftArray as $key => $value)
        <p><strong>{{ $key }} : </strong><br>
            {{ $value }}
        </p>
    @endforeach

</div>
