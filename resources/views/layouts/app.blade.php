<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(config('analytics.google-analytics-key'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.google-analytics-key') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ config('analytics.google-analytics-key') }}');
    </script>
    @endif
    @if(config('analytics.tag-manager-key'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ config('analytics.tag-manager-key') }}');</script>
    <!-- End Google Tag Manager -->
    @endif
    @if(config('analytics.use-plausible'))
    <script async="" defer="" data-domain="{{ config('analytics.plausible-domain') }}" src="{{ config('analytics.plausible-script') }}"></script>
    @endif

    <!-- Preload for speed -->
    <link rel="preload" href="{{ mix('css/app.css') }}" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Nunito&display=swap" as="style">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="{{ mix('js/app.js') }}" as="script">
    <link rel="preload" href="{{ asset('img/turnip-logo.svg') }}" as="image">

    <!-- Favicon, etc. -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/turnip-logo.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="alternate icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="alternate icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#f8fafc">
    <meta name="msapplication-config" content="{{ asset('/favicon/browserconfig.xml') }}">
    <meta name="theme-color" content="#f8fafc">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Pusher Token -->
    <meta name="pusher-token" content="{{ config('broadcasting.connections.pusher.key') }}">
    <!-- Route for dismissing notifications -->
    <meta name="dismiss-notif-route" content="{{ route('notifications.dismiss') }}">

    @stack('meta')

    <title>@yield('title', config('app.name', 'Turnip Queue'))</title>
    <meta name="description" content="@yield('meta-description')">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @stack('css')
</head>
<body>
    @if(config('google.tag-manager-key'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('google.tag-manager-key') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif
    <a class="skip-navigation" href="#content">@lang('Skip to main content')</a>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="d-inline-block align-top" src="{{ asset('img/turnip-logo.svg') }}" alt="logo: illustration of a white turnip with green leaves in front of a blue circle" height="32" width="32" loading="lazy">
                    {{ config('app.name', 'Turnip Queue') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('queue.find') }}">{{ __('Join Queue') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('queue.create') }}">{{ __('Create Queue') }}</a>
                            </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-md-8" id="site-notification-holder">
                    @foreach(App\SiteNotification::active()->get() as $notification)
                    @if(session('notif-dismissed|' . $notification->id) !== true)
                    <div class="alert alert-{{ $notification->type }} mt-4 mb-0 show" data-notif-id="{{ $notification->id }}">
                        <svg style="width:1rem;vertical-align: -0.125em;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" class="svg-inline--fa fa-exclamation-triangle fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg>
                        <span class="message-text">
                            {{ $notification->message }}
                        </span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <main class="py-4" id="content">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container pb-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <a href="{{ route('terms.index') }}" class="col-auto mr-auto">
                                Terms of Service
                            </a>
                            <a href="{{ route('donate.index') }}" class="col-auto ml-auto">
                                Donate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('js')
</body>
</html>
