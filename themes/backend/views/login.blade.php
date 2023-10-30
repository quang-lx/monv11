<!DOCTYPE html>
<html>

<head>
    <base src="{{ URL::asset('/') }}" />
    <meta charset="UTF-8">
    <title>
        @section('title')
            Admin
        @show
    </title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="current-locale" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <!-- Font Awesome -->
    <link href="{{ asset('themes/backend/vendor/admin-lte/plugins/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link href="{{ asset('themes/backend/vendor/admin-lte/dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/backend/vendor/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
        rel="stylesheet">
    <style>
        body {
            display: grid;
            place-items: center;
            font-family: "Nunito", sans-serif;
            height: 100vh;
            background: url({{ url('images/backgroud.png') }});
            background-color: lightgray;
            background-position: 50%;
            background-size: cover;
            background-repeat: no-repeat;
        }

        form {
            background-color: transparent;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        input {
            height: 40px;
            font-size: 14px;
            padding: 10px 12px;
            margin: 8px 0;
            width: 100%;
            color: #333;
            outline: none;
            border-radius: 6px;
            border: 1px solid #C7D0DB;
            background: #FFF;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 0.09px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 1em;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            position: relative;
            overflow: hidden;
            width: 750px;
            max-width: 100%;
            min-height: 550px;
            top: 100px
        }

        .form {
            position: absolute;
            top: 0;
            height: 100%;
        }

        .sign_in {
            left: 50%;
            width: 50%;
            z-index: 2;
            opacity: 1;
            padding: 55px
        }

        .overlay-container {
            position: absolute;
            top: 0;
            left: 0%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            z-index: 100;
            border-radius: 16px 0px 0px 16px;
            background: linear-gradient(29deg, #1976CC 0%, #0FABCD 105.26%);

        }

        .overlay-pannel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
            background: url({{ url('images/image1.png') }});
            background-repeat: no-repeat;
        }

        .sign_in h1 {
            color: #262B2E;
            font-size: 20px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            letter-spacing: 0.26px;
            margin: 35px 0px
        }

        .sign_in button {
            border-radius: 40px;
            background: #1976CC;
            color: #fff;
            height: 40px;
            border: none;
            font-size: 14px;
            margin-top: 40px;
        }

        .account {
            position: relative;
        }

        .account p {
            color: var(--TextColor_pri, #3B4850);
            position: absolute;
            left: 18px;
            top: 1px;
            background-color: #fff;
            font-size: 13px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            letter-spacing: 0.015px;
        }

        .contact {
            color: var(--TextColor_Sec, #617882);
            text-align: center;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .contact p {
            letter-spacing: 0.08px;
            margin: 0px;
            font-size: 14px;
            font-weight: 600
        }

        .contact span {
            letter-spacing: 0.08px;
            margin: 0px;
            font-weight: 500;
            font-size: 14px;
        }

        /* social container */
    </style>
    @section('styles')
    @show
    @stack('css-stack')
    @stack('translation-stack')
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">

    <div class="container" id="container">
        <!-- sign Up form section end-->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-pannel overlay-right">
                    <img src="{{ asset('images/image2.svg') }}" alt="" srcset="">
                </div>
            </div>
        </div>
        <!-- sign in form section start-->
        <div class="form sign_in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <img src="{{ asset('images/image3.svg') }}" alt="" width="101" height="30"
                    srcset="">
                <h1>Đăng nhập</h1>
                <div class="account">
                    <p>Tên đăng nhập</p>
                    <input type="string" name="username" placeholder="Tài khoản">
                </div>
                @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <input type="password" name="password" placeholder="Mật khẩu">
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert" style="display: block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit">Đăng nhập</button>

                <div class="contact">
                    <p>CHĂM SÓC KHÁCH HÀNG</p>
                    <span>Hotline: 18008000 Nhánh 4</span>
                </div>
            </form>
        </div>

    </div>

    <script src="{{ asset('themes/backend/vendor/admin-lte/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('themes/backend/vendor/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('themes/backend/vendor/admin-lte/dist/js/adminlte.min.js') }}"></script>
    @section('scripts')
    @show
    @stack('js-stack')
</body>

</html>
