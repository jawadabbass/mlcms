<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eeeeee"
        style="
        font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';
      ">
        <tbody>
            <tr>
                <td height="30">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table width="650" border="0" align="center" cellpadding="10" cellspacing="0"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <img src="{!! asset_uploads('admin_logo_favicon/' . config('admin_logo_favicon.admin_login_page_logo')) !!}" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table role="presentation" class="column" width="100%"
                                                        border="0" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" bgcolor="#007bff"
                                                                    style="padding: 30px 40px">
                                                                    <h1
                                                                        style="
                                        color: #ffffff;
                                        font-size: 26px;
                                        margin: 0;
                                        font-weight: bold;
                                      ">
                                                                        Contact Form Submitted
                                                                    </h1>
                                                                </td>
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
                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td style="padding: 20px 40px; color: #333; line-height: 26px">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0"
                                        style="font-size: 14px">
                                        <tbody>
                                            <tr>
                                                <td width="100" style="padding: 5px 0">First Name</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="padding: 5px 0">
                                                    <strong>{{ $data['name'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100" style="padding: 5px 0">Last Name</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="padding: 5px 0">
                                                    <strong>{{ $data['lname'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    Email
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    <strong>{{ $data['email'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    Phone
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    <strong>{{ $data['phone'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    Subject
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    <strong>{{ $data['subject'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    Message
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    <strong>{{ $data['comments'] }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    Ip Address
                                                </td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td style="border-top: 1px solid #eee; padding: 5px 0">
                                                    <strong>{{ $ip }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- footer_alt -->
                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="email_body email_end tc">
                                    <table role="presentation" class="content_section" width="100%" border="0"
                                        cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td height="16">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table role="presentation" class="column" width="100%"
                                                        border="0" cellspacing="0" cellpadding="0"
                                                        style="font-size: 14px">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top"
                                                                    style="line-height: 20px">
                                                                    <p>
                                                                        Copyright © {{ date('Y') }}
                                                                        {{ config('app.name') }}. All Rights Reserved
                                                                    </p>
                                                                </td>
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
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
