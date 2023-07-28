<h3><strong>Someone has requested to contact from {{ FindInsettingArr('business_name') }} </strong></h3>
<table width="70%" border="0" cellspacing="1" cellpadding="6"
    style="border:1px solid #ddd; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
    <tr>
        <td width="50%" height="25" bgcolor="#eeeeee"><strong> Name </strong>:</td>
        <td width="50%" bgcolor="#eeeeee"> {{ $data['name'] }} </td>
    </tr>
    <tr>
        <td height="25" width="50%"><strong>Email</strong>:</td>
        <td width="50%">{{ $data['email'] }}</td>
    </tr>
    <tr>
        <td height="25" bgcolor="#eeeeee" width="50%"><strong>Phone No</strong></td>
        <td width="50%" bgcolor="#eeeeee">{{ $data['phone'] }}</td>
    </tr>
    <tr>
        <td height="25" width="50%"><strong>Message</strong></td>
        <td width="50%">{{ $data['comments'] }}</td>
    </tr>
    <tr>
        <td height="25" bgcolor="#eeeeee" width="50%"><strong>IP Address</strong></td>
        <td width="50%" bgcolor="#eeeeee">{{ $ip }}</td>
    </tr>
</table>
