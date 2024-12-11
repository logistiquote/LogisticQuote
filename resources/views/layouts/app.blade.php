<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> {{ isset($page_title) ? $page_title : 'LogistiQuote' }} </title>

    @include('panels.includes.top_includes')

</head>

<body class="bg-gradient-primary">

    @yield('content')

    @include('panels.includes.bottom_includes')

</body>

</html>
