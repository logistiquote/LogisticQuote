<!-- Google tag (gtag.js) -->
@if(env('APP_ENV') === 'production')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VXMH6G7TL4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-VXMH6G7TL4');
    </script>
@endif

