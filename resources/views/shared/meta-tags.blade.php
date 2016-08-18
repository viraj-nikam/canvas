<meta charset="utf-8">

<!-- Facebook Open Graph Tags -->
<meta name="og:type" content="blog">
<meta name="og:site_name" content="{{ config('blog.title') }}">
@yield('og-title')
@yield('og-image')
@yield('og-description')

<!-- SEO Tags -->
<meta name="keywords" content="{{ config('blog.seo') }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="{{ config('blog.author') }}">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="{{ config('blog.description') }}">

<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">