<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{config("app.name")}}</title>
    <link rel="shortcut icon" href="{{asset('/img/favicon.ico')}}">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/aos-2.3.1.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/swiper.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/module.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css?v='.\Carbon\Carbon::now()->format("Y-m-d H:i:s")) }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery-1.7.1.min.js') }}" defer></script>
    <script src="{{ asset('js/swiper.min.js') }}" defer></script>
    <script src="{{ asset('js/aos-2.3.1.js') }}" defer></script>
    <script src="{{ asset('js/common.js') }}" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <!-- Channel Plugin Scripts -->
    <script>
        (function() {
            var w = window;
            if (w.ChannelIO) {
                return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
            }
            var ch = function() {
                ch.c(arguments);
            };
            ch.q = [];
            ch.c = function(args) {
                ch.q.push(args);
            };
            w.ChannelIO = ch;
            function l() {
                if (w.ChannelIOInitialized) {
                    return;
                }
                w.ChannelIOInitialized = true;
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
                s.charset = 'UTF-8';
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
            if (document.readyState === 'complete') {
                l();
            } else if (window.attachEvent) {
                window.attachEvent('onload', l);
            } else {
                window.addEventListener('DOMContentLoaded', l, false);
                window.addEventListener('load', l, false);
            }
        })();
        ChannelIO('boot', {
            "pluginKey": "46d45f61-d50a-45af-a52a-40645e5d1173"
        });
    </script>
    <!-- End Channel Plugin -->
</head>
<body>
@inertia
</body>
</html>
