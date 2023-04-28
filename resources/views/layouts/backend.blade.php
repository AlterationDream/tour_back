<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{ config('app.name') }}@hasSection('title') - @yield('title')@endif</title>

    <meta name="description" content="{{ config('app.name') }} - {{ config('app.description') }}">
    <meta name="author" content="https://meow-cat.ru">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ config('app.name') }}@hasSection('title') - @yield('title')@endif">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:description" content="{{ config('app.name') }} - {{ config('app.description') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon_3.png') }}">
    <link rel="icon" sizes="64x64" href="{{ asset('media/favicons/favicon_3.png') }}">
    <link rel="apple-touch-icon" sizes="64x64" href="{{ asset('media/favicons/favicon_3.png') }}">
{{--<link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">--}}

<!-- Fonts and Styles -->
    @yield('css_before')
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap">--}}
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/pulse.css') }}">
    <link rel="stylesheet" id="css-custom" href="{{ mix('/css/custom.css') }}">
    @yield('css_after')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>

<body>
<!-- Page Container -->
{{--<!--
  Available classes for #page-container:

GENERIC

  'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                              - Theme helper buttons [data-toggle="theme"],
                                              - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                              - ..and/or Codebase.layout('dark_mode_[on/off/toggle]')

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

  ''                                          Classic Header style if no class is added
  'page-header-modern'                        Modern Header style
  'page-header-dark'                          Dark themed Header (works only with classic Header style)
  'page-header-glass'                         Light themed Header with transparency by default
                                              (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
  'page-header-glass page-header-dark'        Dark themed Header with transparency by default
                                              (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

MAIN CONTENT LAYOUT

  ''                                          Full width Main Content if no class is added
  'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
  'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

DARK MODE

  'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
-->--}}
<div id="page-container"
     class="sidebar-o enable-page-overlay side-scroll main-content-boxed remember-theme page-header-fixed">
    <!-- Sidebar -->
    {{--<!--
      Helper classes

      Adding .smini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
      Adding .smini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
        If you would like to disable the transition, just add the .no-transition along with one of the previous 2 classes

      Adding .smini-hidden to an element will hide it when the sidebar is in mini mode
      Adding .smini-visible to an element will show it only when the sidebar is in mini mode
      Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
    -->--}}
    <nav id="sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header justify-content-lg-center">
                <!-- Logo -->
                <div>
            <span class="smini-visible fw-bold tracking-wide fs-lg">
              c<span class="text-primary">b</span>
            </span>
                    <a class="link-fx fw-bold tracking-wide mx-auto" href="/">
                        <span class="smini-hidden">
                            <img src="/media/favicons/favicon_3.png" class="site-logo">
                            <span class="fs-3 text-dual">Тур</span><span class="fs-3 text-primary">&nbsp;Вояж</span>
                        </span>
                    </a>
                </div>
                <!-- END Logo -->

                <!-- Options -->
                <div>
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-sm btn-alt-danger d-lg-none" data-toggle="layout"
                            data-action="sidebar_close">
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                    <!-- END Close Sidebar -->
                </div>
                <!-- END Options -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div class="js-sidebar-scroll">
                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        {{--<li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                                <i class="nav-main-link-icon fa fa-house-user"></i>
                                <span class="nav-main-link-name">Статистика</span>
                            </a>
                        </li>--}}
                        <li class="nav-main-heading">Контент</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link  {{ request()->is('tours*') ? 'active' : '' }}" href="{{ route('tours') }}">
                                <i class="nav-main-link-icon fa fa-compass"></i>
                                <span class="nav-main-link-name">Туры</span>
                            </a>
                        </li>
                        <li class="nav-main-item {{ request()->is('services*') ? 'open' : ''}}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                               aria-haspopup="true" aria-expanded="{{ request()->is('services*') ? 'true' : 'false' }}" href="#">
                                <i class="nav-main-link-icon fa fa-handshake"></i>
                                <span class="nav-main-link-name">Услуги</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->is('services/categories*') ? 'active' : '' }}"
                                       href="{{ route('services.categories') }}">
                                        Категории
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->is('services/listings*') ? 'active' : '' }}"
                                       href="{{ route('services') }}">
                                        Услуги
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->is('services/settings*') ? 'active' : '' }}"
                                       href="{{ route('services.settings') }}">
                                        Настройки свойств услуг
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item {{ request()->is('info-pages*') ? 'open' : ''}}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                               aria-haspopup="true" aria-expanded="{{ request()->is('info-pages*') ? 'true' : 'false' }}" href="#">
                                <i class="nav-main-link-icon fa fa-info-circle"></i>
                                <span class="nav-main-link-name">Информационные страницы</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->is('info-pages/about-us') ? 'active' : '' }}"
                                       href="{{ route('info-pages.about-us') }}">
                                        О нас
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->is('info-pages/vip') ? 'active' : '' }}"
                                       href="{{ route('info-pages.vip') }}">
                                        VIP
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </div>
            <!-- END Sidebar Scrolling -->
        </div>
        <!-- Sidebar Content -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="space-x-1">
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- END Toggle Sidebar -->

                <!-- Dark Mode -->
                <button type="button" class="btn btn-sm btn-alt-secondary"
                        id="page-header-themes-dropdown" data-toggle="layout" data-action="dark_mode_toggle"
                        href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="Тёмная/Светлая тема">
                    <i class="fa fa-burn"></i>
                </button>
                <!-- END Dark Mode -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="space-x-1">
                <!-- User Dropdown -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user d-sm-none"></i>
                        <span class="d-none d-sm-inline-block fw-semibold">{{ auth()->user()->name }}</span>
                        <i class="fa fa-angle-down opacity-50 ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0"
                         aria-labelledby="page-header-user-dropdown">
                        <div class="px-2 py-3 bg-body-light rounded-top">
                            <h5 class="h6 text-center mb-0">
                                {{ auth()->user()->name }}
                            </h5>
                        </div>
                        <div class="p-2">
                            <a class="dropdown-item d-flex align-items-center justify-content-between space-x-1"
                               href="{{ route('signOut') }}">
                                <span>Выйти</span>
                                <i class="fa fa-fw fa-sign-out-alt opacity-25"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END User Dropdown -->
            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Loader -->
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="far fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        @yield('content')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end" style="font-size: 12px;">
                    Сделано <a class="fw-semibold" href="https://meow-cat.ru/" target="_blank">лапками</a> с <i
                        class="fa fa-heart text-danger"></i>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="https://tour-voyazh.ru/" target="_blank">Тур Вояж</a> &copy; <span
                        data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Page Container -->

<!-- Codebase Core JS -->
<script src="{{ mix('js/codebase.app.js') }}"></script>


<!-- Errors and success messages -->
<script src="/js/lib/jquery.min.js"></script>
<script src="/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        Codebase.helpers('jq-notify', {
            icon: 'fa fa-times me-5',
            message: '{{ $error }}',
            align: 'center',
            from: 'bottom',
            type: 'danger',
        });
        @endforeach
    </script>
@endif
@if(session()->has('success'))
    <script>
        Codebase.helpers('jq-notify', {
            icon: 'fa fa-check me-5',
            message: '{{ session()->get('success') }}',
            align: 'center',
            from: 'bottom',
            type: 'success',
        });
    </script>
@endif
<!-- END Errors and success messages -->

<!-- Laravel Scaffolding JS -->
<!-- <script src="{{ mix('js/laravel.app.js') }}"></script> -->

@yield('js_after')
</body>

</html>
