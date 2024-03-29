<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Veo Chen | Web Developer</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

    <script>
        window.recaptchaKey = "{{ config('services.recaptcha.key') }}";
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer></script>
</head>

<body>
<div id="root"></div>

<footer class="ubuntu-mono">
    <div class="container text-xs-center">
        <div class="copyright">
            ©COPYRIGHT 2016-{{ \Carbon\Carbon::today()->year }} veoveo.me
        </div>
        <div class="text-uppercase">
            <a href="https://github.com/sudomabider" target="_blank">
                <i class="fa fa-github"></i> sudomabider
            </a>
        </div>
    </div>
</footer>

<script>
    window.userName = "{{ config('resume.user.name') }}";
    window.altName = "{{ config('resume.user.name_alt') }}";
</script>
<script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>