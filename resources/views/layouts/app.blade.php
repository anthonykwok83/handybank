<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <title>Handy Bank API demonstration</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
</head>
<body>

@yield('content')

@section('footer_js')
    {{--<script src="https://cdn.jsdelivr.net/npm/vue"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.4/vue.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    {{--<script>hljs.initHighlightingOnLoad();</script>--}}
    <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
            crossorigin="anonymous"></script>

    <script>
        var token = document.head.querySelector('meta[name="csrf-token"]');

        if (token) {
            window.jQuery.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': token.content  }
            });
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }

    </script>


    <script>
        Vue.directive('highlightjs', {
            deep: true,
            bind: function (el, binding) {
                // on first bind, highlight all targets
                var targets = el.querySelectorAll('code');
                targets.forEach(function (target) {
                    // if a value is directly assigned to the directive, use this
                    // instead of the element content.
                    if (binding.value) {
                        target.textContent = binding.value
                    }
                    hljs.highlightBlock(target);
                });
            },
            componentUpdated: function (el, binding) {
                // after an update, re-fill the content and then highlight
                var targets = el.querySelectorAll('code');
                targets.forEach( function (target) {
                    if (binding.value) {
                        target.textContent = binding.value;
                        hljs.highlightBlock(target);
                    }
                });
            }
        })
    </script>


@show

</body>
</html>
