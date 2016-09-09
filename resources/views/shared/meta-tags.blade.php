<meta charset="utf-8">

<!-- Facebook Open Graph Tags -->
<meta name="og:type" content="blog">
<meta name="og:site_name" content="{{ Settings::blogTitle() }}">
@yield('og-title')
@yield('og-image')
@yield('og-description')

<!-- SEO Tags -->
<meta name="keywords" content="{{ Settings::blogSeo() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="{{ Settings::blogAuthor() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="{{ Settings::blogDescription() }}">

<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">