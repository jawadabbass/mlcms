<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Real Friends</title>
</head>
<body>

    <table align="center" border="0" cellpadding="0" cellspacing="1" style="background:#ffffff" width="594">
        <tbody>
            <tr>
                <td width="80%">
                    <table align="center" border="0" cellpadding="0" cellspacing="5" style="background:#ffffff" width="593">
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0"  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;" width="100%">
                                        <tbody>
                                            <tr>
                                                <td height="110" align="center"><img src="{{ asset_storage('front/images/logo.png') }}" alt=""></td>
                                            </tr>
                                            <tr>
                                                <td height="40" bgcolor="#f4f4f4" valign="middle" style="font-size:16px; color:#211e1e; font-weight:bold; font-family:Arial, Helvetica, sans-serif;" align="center">{{$data['subject']}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="583" height="15">&nbsp;</td>
                            </tr>

                            <tr>
                                <td width="583" height="280" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#ffffff" width="33">&nbsp;</td>
                                                <td bgcolor="#ffffff" height="35" width="487">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor="#ffffff" height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px; color:#000; font-weight:normal;" width="134">
                                                                    @php
                                                                    $message=str_replace(array('{CLIENT_NAME}','{NAME}','{TITLE}','{COMPANY E-MAIL}'), array($name,$admin,$title,$com_email), $data['user_body']);
                                                                    echo $message;
                                                                    @endphp
                                                                    
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td bgcolor="#ffffff" width="33">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="583" height="40">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
          


                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
   
</body>

</html>
