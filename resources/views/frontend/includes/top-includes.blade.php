    
    <!-- Index page includes -->
    <link href="{{ asset('public/frontend/css/partial-mp-filter.css0cdb.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/frontend/css/global.css9bed.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('public/frontend/js/main.min.jse003.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/libs/jquery-ui-custom.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/libs/bootstrap-datepicker.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/libs/select2.min489b.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/libs/slick.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/frontend/libs/gsap.min8347.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/libs/TweenMax.min8347.js') }}"></script> -->
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/libs/ScrollMagic.min8347.js') }}"></script> -->
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/libs/animation.gsap.min8347.js') }}"></script> -->
    <!-- <script type="text/javascript" src="{{ asset('public/frontend/libs/debug.addIndicators.min8347.js') }}"></script> -->

    @if( isset($page_name) )
        @if($page_name == 'homepage')
        <script type="text/javascript" src="{{ asset('public/frontend/js/index5493.js') }}"></script>
        <link href="{{ asset('public/frontend/css/index.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @elseif($page_name == 'get_quote_step2')
        <!-- Request quote includes -->
        <link href="{{ asset('public/frontend/css/bundle.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @endif
        @if($page_name == 'contact_us')    
        <link href="{{ asset('public/frontend/css/contact_us.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @endif
    @endif
    
    @if( ! isset($page_name) )
        <!-- Login page css -->
        <link href="{{ asset('public/frontend/css/auth.css') }}" media="screen" rel="stylesheet" type="text/css" />
    @endif

    <!-- Font awesome includes -->
    <link rel="stylesheet" href="{{ asset('public/fontawesome/css/all.css') }}">
    <!-- <script type="text/javascript" src="{{ asset('public/fontawesome/js/all.js') }}"></script> -->
