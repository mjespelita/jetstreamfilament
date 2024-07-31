<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        <link rel="stylesheet" href="{{ url('build/assets/app-CKF9trwW.css') }}">
        <script src="{{ url('build/assets/app-58r_jytx.js') }}"></script>
    </head>
    <body>
        {{ $slot }}

        <script>
            // Listening to the channel and event
            document.addEventListener('DOMContentLoaded', () => {
                Echo.channel('sample-channel')
                    .listen('SampleEvent', (event) => {
                        console.log(event); // Handle the event data here
                    });
            });
        </script>
    </body>
</html>
