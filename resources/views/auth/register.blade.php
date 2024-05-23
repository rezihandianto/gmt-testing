<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <!-- Page Container -->
    <!--
        Available classes for #page-container:
    
    GENERIC
    
      'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                  - Theme helper buttons [data-toggle="theme"],
                                                  - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                  - ..and/or One.layout('dark_mode_[on/off/toggle]')
    
    SIDEBAR & SIDE OVERLAY
    
      'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
      'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
      'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
      'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
      'sidebar-dark'                              Dark themed sidebar
    
      'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
      'side-overlay-o'                            Visible Side Overlay by default
    
      'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens
    
      'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)
    
    HEADER
    
      ''                                          Static Header if no class is added
      'page-header-fixed'                         Fixed Header
    
    HEADER STYLE
    
      ''                                          Light themed Header
      'page-header-dark'                          Dark themed Header
    
    MAIN CONTENT LAYOUT
    
      ''                                          Full width Main Content if no class is added
      'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
      'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
    
    DARK MODE
    
      'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
    -->
    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('assets/media/photos/photo28@2x.jpg');">
                <div class="row g-0 bg-primary-dark-op">
                    <!-- Meta Info Section -->
                    <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                        <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <a class="link-fx fw-semibold fs-2 text-white" href="/">
                                    GMT<span class="fw-normal"> Company</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- END Meta Info Section -->

                    <!-- Main Section -->
                    <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-extra-light">
                        <div class="p-3 w-100 d-lg-none text-center">
                            <a class="link-fx fw-semibold fs-3 text-dark" href="/">
                                GMT<span class="fw-normal"> Company</span>
                            </a>
                        </div>
                        <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <!-- Header -->
                                <div class="text-center mb-5">
                                    <h1 class="fw-bold mb-2">
                                        Create Account
                                    </h1>
                                    <p class="fw-medium text-muted">
                                        Get your access today in one easy step
                                    </p>
                                </div>
                                <!-- END Header -->

                                <!-- Sign Up Form -->
                                <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _js/pages/op_auth_signup.js) -->
                                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                <div class="row g-0 justify-content-center">
                                    <div class="col-sm-8 col-xl-4">
                                        <form class="js-validation-signup" action="{{ route('register') }}"
                                            method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-alt py-3 @error('name') is-invalid @enderror"
                                                    id="name" name="name" placeholder="Name"
                                                    value="{{ old('name') }}" autocomplete="name" autofocus>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <input type="email"
                                                    class="form-control form-control-lg form-control-alt py-3 @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="Email"
                                                    value="{{ old('email') }}" autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-alt py-3 @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Password"
                                                    autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-alt py-3"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Confirm Password" autocomplete="new-password">
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <div>
                                                    <a class="text-muted fs-sm fw-medium d-block d-lg-inline-block mb-1"
                                                        href="{{ route('login') }}">
                                                        Already have an account? Sign in
                                                    </a>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-lg btn-alt-success">
                                                        <i class="fa fa-fw fa-plus me-1 opacity-50"></i> Sign Up
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Sign Up Form -->
                            </div>
                        </div>
                    </div>
                    <!-- END Main Section -->
                </div>
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    <!--
        OneUI JS
    
        Core libraries and functionality
        webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>

    <!-- jQuery (required for jQuery Validation plugin) -->
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

    <!-- Page JS Code -->
    {{-- <script src="assets/js/pages/op_auth_signup.min.js"></script> --}}
</body>

</html>
