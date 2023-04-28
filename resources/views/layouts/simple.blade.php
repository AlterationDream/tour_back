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

  <!-- Fonts and Styles -->
  @yield('css_before')
    {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800&display=swap">--}}
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/pulse.css') }}">
    <link rel="stylesheet" id="css-custom" href="{{ mix('/css/custom.css') }}">

  <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}"> -->
  @yield('css_after')

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Scripts -->
  <script>
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
  </script>
</head>

<body>
  <div id="page-container" class="main-content-boxed">
    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
    </main>
    <!-- END Main Container -->
  </div>
  <!-- END Page Container -->

  <!-- Codebase Core JS -->
  <script src="{{ mix('js/codebase.app.js') }}"></script>

  <!-- Laravel Original JS -->
  <!-- <script src="{{ mix('js/laravel.app.js') }}"></script> -->

  @yield('js_after')
</body>

</html>
