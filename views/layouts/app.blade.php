<!DOCTYPE html>
@include('elements.base')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', setting('description', ''))">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">

    <meta property="og:title" content="@yield('title')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ favicon() }}">
    <meta property="og:description" content="@yield('description', setting('description', ''))">
    <meta property="og:site_name" content="{{ site_name() }}">
    @stack('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ site_name() }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ favicon() }}">

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('vendor/axios/axios.min.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ theme_asset('js/navigation.js') }}" defer></script>

    <!-- Page level scripts -->
    @stack('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ theme_asset('css/style.css') }}?v=1.0.4" rel="stylesheet">
    @stack('styles')
</head>

<body>
<div id="app">
    <header>
        @include('elements.navbar')
    </header>

    <main>
        <div class="container">
            @include('elements.session-alerts')
        </div>

        <div id="go-to-bottom-div">
            @yield('content')
        </div>
    </main>
</div>

<footer class="footer">
    <div class="top-footer">
        <div class="top-footer-content">
            <div class="container">
                <div class="about">
                    <div class="content">
                        <h3 class="footer-title">{{ site_name() }}</h3>
                        <p>{{ theme_config("footer_description") }}</p>
                    </div>
                </div>

                <div class="socials">
                    <div class="social-links">
                        @foreach(['twitter', 'youtube', 'discord', 'steam', 'teamspeak', 'instagram'] as $social)
                            @if($socialLink = theme_config("footer_social_{$social}"))
                                <a href="{{ $socialLink }}" target="_blank">
                                    <i class="fab fa-{{ $social }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="links">
                    <div class="content">
                        <h3 class="footer-title">{{ trans('theme::theme.footer_links_title') }}</h3>
                        @foreach(theme_config('footer_links') ?? [] as $link)
                            <a href="{{ $link['value'] }}">{{ $link['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="copyright">
        <div class="container">
            {{ setting('copyright') }} | @lang('messages.copyright')
            <p style="margin-top: 10px;font-size: 10px;">
                <a class="mention" href="https://twitter.com/Captain34_dev" target="_blank">
                    Designed with <i style="color: orangered;" class="fas fa-heart"></i> by Captain34 & Sloyni
                </a>
            </p>
        </div>
    </div>
</footer>
@stack('footer-scripts')
</body>
</html>
