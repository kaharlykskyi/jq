<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Just Quality</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700" rel="stylesheet">

    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="flex-center position-ref full-height">

        <div class="content">
            <img src="{{ asset('images/jq.png') }}" alt="JQ" class="circle-logo">
            <div class="title-small m-b-xs m-t-md">
               Hi, <span class="redirect-name">@auth {{ Auth::user()->name }} @else guest @endauth</span>!
            </div>
            <div class="title-small m-b-md">
                We are checking your servers ... You will be redirected in <span id="counter">{{ env('REDIRECT_TIMEOUT') }}</span> seconds
            </div>
        </div>
    </div>
    <script src="{{ asset('js/redirect.js') }}"></script>
</body>
</html>
