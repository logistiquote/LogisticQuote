
    <!-- Index page includes -->
    <link href="{{ asset('frontend/css/partial-mp-filter.css0cdb.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/global.css9bed.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <link href="{{ asset('frontend/css/custom.css') }}" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('frontend/js/main.min.jse003.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/libs/jquery-ui-custom.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/libs/bootstrap-datepicker.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/libs/select2.min489b.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/libs/slick.mine23c.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/libs/gsap.min8347.js') }}"></script>

    @if(isset($page_name))
        @if($page_name == 'homepage')
        <link href="{{ asset('frontend/css/index.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @elseif($page_name == 'get_quote_step2' || $page_name == 'get_quote_step3')
        <!-- Request quote includes -->
        <link href="{{ asset('frontend/css/bundle.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @endif
        @if($page_name == 'contact_us')
        <link href="{{ asset('frontend/css/contact_us.css') }}" media="screen" rel="stylesheet" type="text/css" />
        @endif
    @endif

    @if(!isset($page_name))
        <!-- Login page css -->
        <link href="{{ asset('frontend/css/auth.css') }}" media="screen" rel="stylesheet" type="text/css" />
    @endif

    <!-- Font awesome includes -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
