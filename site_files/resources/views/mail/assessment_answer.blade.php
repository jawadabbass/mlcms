<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Real Friends</title>
</head>

<body>

    <table align="center" border="0" cellpadding="0" cellspacing="1" style="background:#ffffff" width="600">
        <tbody>
            <tr>
                <td width="100%">
                    <table align="center" border="0" cellpadding="0" cellspacing="5" style="background:#ffffff"
                        width="593">
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0"
                                        style="font-family:Arial, Helvetica, sans-serif;" width="100%">
                                        <tbody>
                                            <tr>
                                                <td height="110" align="center"><img
                                                        src="{{ assets('front/img/logo.png') }}"
                                                        alt=""></td>
                                            </tr>
                                            <tr>
                                                <td height="40" bgcolor="#f4f4f4" valign="middle"
                                                    style="font-size:16px; color:#211e1e; font-weight:bold; font-family:Arial, Helvetica, sans-serif;"
                                                    align="center">{{ $subject }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" height="15">&nbsp;</td>
                            </tr>

                            <tr>
                                <td width="100%" height="100" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#ffffff" width="33">&nbsp;</td>
                                                <td bgcolor="#ffffff" height="35" width="487">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                        width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor="#ffffff" height="40"
                                                                    style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:20px; color:#000; font-weight:normal;"
                                                                    width="134">
                                                                    Hi Real Friends Admins<br />
                                                                    {{ $name }} has answered the following
                                                                    Questions below. You can also find them under their
                                                                    profile in the back admin.


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
                                <td bgcolor="#eac459" valign="middle" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#eac459" width="30">&nbsp;</td>
                                                <td bgcolor="#eac459" height="40"
                                                    style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; border-right:1px solid #e2e2e2; color:#000; font-weight:normal; padding:0 10px;"
                                                    width="353">Question(s)</td>
                                                <td bgcolor="#eac459" align="center" height="40"
                                                    style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#000; font-weight:normal; padding:0 10px;"
                                                    width="170">Answer(s)</td>
                                                <td bgcolor="#eac459" width="30">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td bgcolor="white" valign="middle" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            
                                            <?php $i = 1; ?>
                                            
                                            @foreach ($data as $do2)
                                            
                                                            @php
                                            
                                                             $bgColor = '#f1f1f1';
                                                                if ($i % 2 == 0) {
                                                                    $bgColor = '#ffffff';
                                                                }
                                                            @endphp        
                                                <tr>
                                                    <td bgcolor="#ffffff" width="30">&nbsp;</td>
                                                    <td bgcolor="{{ $bgColor }}" height="40"
                                                        style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; padding:10px; border-right:1px solid #e2e2e2; color:#000; font-weight:normal; padding:0 10px;"
                                                        width="270">
                                                        {{ $do2->assessment_question->question }}
                                                    </td>
                                                    <td bgcolor="{{ $bgColor }}" align="center" height="40"
                                                        style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:20px; color:#000; font-weight:normal; padding:10px;"
                                                        width="270">

                                                        @if (is_array(json_decode($do2->answer)) || is_object(json_decode($do2->answer)))
                                                            @foreach (json_decode($do2->answer) as $di)
                                                                {{ $di }}
                                                            @endforeach
                                                        @else
                                                            {{ $do2->answer }}
                                                        @endif
                                                    </td>
                                                    <td bgcolor="#ffffff" width="30">&nbsp;</td>
                                                </tr>
                                                
                                                @php 
                                                
                                                $i++;
                                                
                                                @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                </td>
                            </tr>



                            <tr>
                                <td width="100%" height="40">&nbsp;</td>
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
