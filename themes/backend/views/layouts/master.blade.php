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
    <meta name="user-api-token" content="{{ $jwt_token }}">
    <meta name="current-locale" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,500,400i,700&display=fallback">

    {!! \Modules\Mon\Support\Facades\Theme::css('vendor/admin-lte/plugins/fontawesome-free/css/all.min.css') !!}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {!! \Modules\Mon\Support\Facades\Theme::css(
        'vendor/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
    ) !!}
    {!! \Modules\Mon\Support\Facades\Theme::css(
        'vendor/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
    ) !!}
    {!! \Modules\Mon\Support\Facades\Theme::css('vendor/admin-lte/dist/css/adminlte.min.css') !!}
    {!! \Modules\Mon\Support\Facades\Theme::css(
        'vendor/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
    ) !!}

    {!! \Modules\Mon\Support\Facades\Theme::css('css/app.css') !!}
    <link rel="stylesheet" href="{{ url('css/icons.css') }}">

    @include('backend::partials.globals')
    @section('styles')

    @show
    @stack('css-stack')
    @stack('translation-stack')
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/jquery/jquery.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/jquery-ui/jquery-ui.min.js') !!}

    <script>
        $.ajaxSetup({
            headers: {
                'Authorization': 'Bearer  {{ $jwt_token }}'
            }
        });
        var AuthorizationHeaderValue = 'Bearer  {{ $jwt_token }}';
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">

    @routes
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>
            @include('backend::partials.top-nav')

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->

        @include('backend::partials.sidebar-nav')

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('backend::partials.notifications')
                        @yield('content')
                        <router-view></router-view>
                    </div>
                </div>
            </div>


        </div>
        {{-- @include('backend::partials.footer') --}}

    </div><!-- ./wrapper -->
    <script>
        window.MonCMS = {

            locales: {!! json_encode(supported_locales()) !!},
            currentLocale: '{{ app()->getLocale() }}',
            adminPrefix: 'admin',
            googleApiKey: '{{ env('GOOGLE_API_KEY') }}',
            appUrl: '{{ env('APP_URL') }}',
            filesystem: '{{ config('config.filesystem.default') }}',
            translations: '',
            editorUploadUrl: '{{ route('api.media.editor.store') }}',
            user_token: '{{ $jwt_token }}',
            multipleLanguage: '{{ config('mon.multiple_languages') }}',
            permissions: {!! json_encode($permissions) !!},
            permissionDenied: '{{ trans('backend::mon.message.permission_denied') }}',

        };
    </script>

    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/plugins/moment/moment.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js(
        'vendor/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
    ) !!}
    {!! \Modules\Mon\Support\Facades\Theme::js(
        'vendor/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
    ) !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/admin-lte/dist/js/adminlte.min.js') !!}
    {!! \Modules\Mon\Support\Facades\Theme::js('vendor/tinymce/tinymce4.7.5/tinymce.min.js') !!}

    {!! \Modules\Mon\Support\Facades\Theme::js('js/app.js') !!}
    @section('scripts')
    @show
    @stack('js-stack')

    <script>
        $(document).ready(function() {
            $(".show-hide-pass").click(function() {
                let element = $(this).parent($('.formPassword')).find('input')
                console.log(element)
                element.attr('type') == 'password' ? element.attr('type', 'string') : element.attr('type',
                    'password')
            })
        })
    </script>
</body>

</html>
