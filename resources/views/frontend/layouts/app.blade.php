<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta name="referrer" content="always">
    <meta charset="utf-8">
    <meta name="Author" content="LogistiQuote">
    <meta property="og:site_name" content="LogistiQuote">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="design/images/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="design/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="design/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="design/images/favicon/favicon-16x16.png') }}">
    
    <meta name="application-name" content="LogistiQuote.com" />
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title> {{ isset($page_title) ? $page_title : 'LogistiQuote' }} </title>

    @include('frontend.includes.top-includes')
    @include('frontend.includes.top-scripts')

</head>

<body>
    @include('frontend.snippets.header')

    @yield('content')

    @include('frontend.snippets.footer')

    @include('frontend.includes.bottom-scripts')
    
    @yield('bottom_scripts')

</body>

</html>
