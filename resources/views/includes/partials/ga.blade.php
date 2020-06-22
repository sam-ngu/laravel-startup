@if(config("analytics.google-analytics") && config("analytics.google-analytics") != "UA-XXXXX-X")
    {{-- Google Analytics: change UA-XXXXX-X to be your site's ID. --}}
    <script>


        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ config("analytics.google-analytics") }}', 'auto');
        ga('send', 'pageview');

        {{--(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=--}}
        {{--    function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;--}}
        {{--    e=o.createElement(i);r=o.getElementsByTagName(i)[0];--}}
        {{--    e.src='//www.google-analytics.com/analytics.js';--}}
        {{--    r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));--}}
        {{--ga('create','{{ config("analytics.google-analytics") }}','auto');--}}
        {{--ga('send','pageview');--}}
    </script>

@endif
