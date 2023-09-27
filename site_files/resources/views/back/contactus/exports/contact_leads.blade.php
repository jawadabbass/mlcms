<table>
    <tr>
        <td>Dated</td>
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>City</td>
        <td>State</td>
        <td>Company</td>
        <td>Message</td>
    </tr>
    @foreach ($contact_leads as $lead)
        <tr>
            <td>{{ date('m-d-Y', strtotime($lead->dated)) }}</td>
            <td>{{ $lead->name }}</td>
            <td>{{ $lead->email }}</td>
            <td>{{ $lead->phone }}</td>
            <td>{{ $lead->city }}</td>
            <td>{{ $lead->state }}</td>
            <td>{{ $lead->company_name }}</td>
            <td>{{ $lead->comments }}</td>
        </tr>
    @endforeach
</table>
