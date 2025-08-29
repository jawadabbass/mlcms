<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                    <!-- header_center -->
                    {{ $header ?? '' }}
                    <!-- hero_welcome -->
                    <table align="center" width="650" border="0" cellspacing="0" cellpadding="0"
                        bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td style="padding: 20px;">
                                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                                    {{ $subcopy ?? '' }}

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- content -->
                    <!-- footer_alt -->
                    {{ $footer ?? '' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
