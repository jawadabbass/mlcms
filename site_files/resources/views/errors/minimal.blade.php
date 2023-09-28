<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Raleway:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <title>@yield('title')</title>
    <style>
        .error-page-wrap {
            padding: 100px 0;
        }

        .error-page-wrap .errormain {
            text-align: center;
        }

        .error-page-wrap .errormain h2 {
            font-size: 280px;
            color: #333;
            font-weight: 700;
            line-height: 280px;
        }

        .error-page-wrap .errormain h3 {
            font-size: 40px;
            color: #888;
            font-weight: 900;
            line-height: 50px;
            letter-spacing: 5px;
            display: inline-block;
            border: 3px solid #ddd;
            padding: 10px 40px;
            margin-top: -20px;
        }

        .error-msg {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .error-msg p {
            max-width: 600px;
            margin: auto;
            line-height: 24px;
            font-size: 22px;
            color: #666;
        }

        .errormain .primary-btn {
            display: inline-block;
            font-size: 16px;
            background: #333;
            color: #fff;
            border: none;
            padding: 15px 35px;
            position: relative;
            font-weight: 700;
            text-align: center;
            border-radius: 4px;
        }

        .errormain .primary-btn:hover {
            background: #000;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-page-wrap">
            <div class="errormain">
                <h2>@yield('code')</h2>
                <h3>@yield('title')</h3>
                <div class="error-msg">
                    <p>@yield('message')</p>
                </div>
                <a href="{{ url('/') }}" class="primary-btn">Back to Home Page</a>
            </div>
        </div>
    </div>
</body>

</html>
