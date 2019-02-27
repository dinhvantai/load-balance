<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('userTitle') </title>
    <meta name="description" content="@yield('seoDescription')">
    <meta name="keywords" content="@yield('seoKeyword')">
    <meta content="DOCUMENT" name="RESOURCE-TYPE">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link href="{{ mix('/css/user/screen.css') }}" type="text/css" rel="stylesheet">

    @yield('addCss')
</head>

<body>
    <div class="bdw">

        @include('user.library.header')

        <!--list-hotline-header-->
        <div class="mc">
            <ul class="ul mc">
                @include('user.library.sidebar')

                @yield('content')
            </ul>

            <div class="clear10px"></div>
            
            @include('user.library.menu-footer')

        </div>

        @include('user.library.footer')

    </div>

    @yield('addJavaScript')
</body>

</html>
