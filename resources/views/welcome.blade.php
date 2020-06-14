<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Just Quality</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}" class="jq-default-a">
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="jq-avatar-circle">
                        {{ Auth::user()->name }}
                    </a>
                @else
                    <a href="{{ route('auth.social', 'discord') }}" class="bttn-dark">Login with Discord</a>
                @endauth
            </div>

            <div class="content">
                <img src="{{ asset('images/jq.png') }}" alt="JQ" class="circle-logo">
                <div class="title m-b-md">
                    Just Quality
                </div>
            </div>
        </div>
    </body>
</html>
