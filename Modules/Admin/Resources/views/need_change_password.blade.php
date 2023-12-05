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
    {!! \Modules\Mon\Support\Facades\Theme::css('vendor/admin-lte/plugins/fontawesome-free/css/all.min.css') !!}

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {!! \Modules\Mon\Support\Facades\Theme::css('vendor/admin-lte/dist/css/adminlte.min.css') !!}
    {!! \Modules\Mon\Support\Facades\Theme::css('vendor/admin-lte/plugins/toastr/toastr.min.css') !!}
    {!! \Modules\Mon\Support\Facades\Theme::css(
        'vendor/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
    ) !!}

    <style>
        .login-page {
            justify-content: normal;
        }

        body {
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

        .login-box {
            width: 900px;
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
            width: 900px;
            max-width: 100%;
            min-height: 650px;
            top: 80px;
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
            padding: 55px;
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

        .overlay {
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
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
            color: rgba(0, 0, 0, 0.80);
            font-family: Roboto;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            /* 150% */
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
            line-height: 1;
        }

        .contact p {
            letter-spacing: 0.08px;
            margin: 0px;
            font-size: 13px;
            font-weight: 600
        }

        .contact span {
            letter-spacing: 0.08px;
            margin: 0px;
            font-weight: 500;
            font-size: 13px;
        }

        .license {
            text-align: center;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 13px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 0.08px;
        }

        .arrow {
            display: flex;
            width: 32px;
            height: 32px;
            padding: 6px;
            justify-content: center;
            align-items: center;
            border-radius: 6px;
            border: 1px solid var(--blue-3, #79B8FF);
            background: var(--blue-20, #E3F2FD);
            margin-right: 16px
        }

        .logout {
            margin-top: 49px;
            margin-bottom: 32px
        }

        .formPassword {
            margin-bottom: 16px;
            position: relative;
        }

        .formPassword img {
            position: absolute;
            right: 12px;
            top: 45px;
        }

        .formPassword label {
            color: var(--gray-9, #2F3748);
            /* Body/14/Regular */
            font-family: Roboto;
            font-size: 14px;
            font-style: normal;
            font-weight: 400 !important;
            line-height: 20px;
            /* 142.857% */
            margin-bottom: 0px
        }

        .formPassword input {
            margin: 0px display: flex;
            height: 48px;
            padding: 4px 12px;
            align-items: center;
            gap: 4px;
            align-self: stretch;
            border-radius: 4px;
            border: 1px solid var(--gray-1, #D1DAEB);
            background: var(--common-1, #FFF);
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
    {{-- {{dd($errors->first())}} --}}
    <div class="login-box">
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
                <form method="POST" action="{{ route('change-password') }}">
                    @csrf
                    <img src="{{ asset('images/image3.svg') }}" alt="" width="118" height="35"
                        srcset="">
                    <h1 class="d-flex align-items-center logout">
                        <a class="arrow" href="{{ route('logout') }}" role="button">
                            <img src="{{ asset('images/arrow-left.svg') }}" alt="" srcset="">
                        </a>

                        Hãy đổi mật khẩu để sử dụng tính năng
                    </h1>
                    <div class="formPassword">
                        <label>Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="password" placeholder="Thiết lập mật khẩu sau lần đầu đăng nhập">
                        <img role="button" class="show-hide-pass" src="{{ asset('images/eye.svg') }}" alt=""
                            srcset="">
                    </div>
                    <div class="formPassword">
                        <label>Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                        <img role="button" class="show-hide-pass" src="{{ asset('images/eye.svg') }}" alt=""
                            srcset="">
                    </div>
                    <button type="submit">Lưu</button>

                    <div class="contact">
                        <p>CHĂM SÓC KHÁCH HÀNG</p>
                        <span>Hotline: 18008000 Nhánh 4</span>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <p class="license">
        2017© Bản quyền thuộc Tập đoàn Công nghiệp Viễn thông Quân Đội
    </p>
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/jquery/jquery.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/toastr/toastr.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/dist/js/adminlte.min.js') !!}

    @section('scripts')
    @show

    @stack('js-stack')

    {{-- @if (session('success')) --}}


    @if (session('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}", '', {
                    closeButton: true
                })
            })
        </script>
    @endif

    @if ($errors->first())
        <script>
            $(document).ready(function() {
                toastr.error("{{ $errors->first() }}", '', {
                    closeButton: true
                })
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $(".show-hide-pass").click(function() {
                let element = $(this).parent($('.formPassword')).find('input')
                element.attr('type') == 'password' ? element.attr('type', 'string') : element.attr('type',
                    'password')
            })
        })
    </script>




    {{-- @endif --}}

</body>

</html>
