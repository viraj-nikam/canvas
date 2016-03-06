@extends('home.master')

@section('content')
    <a href="/" class="nav-link">Home</a>
    <a href="/blog" class="nav-link">Blog</a>
    <a href="#" class="nav-link">GitHub</a>

    <div class="container-fluid">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-fw fa-text-width fa-2x features"></i> <span class="lead features">Markdown</span>
                    <p>All content is stored as markdown so its portable and easy to move in and out.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-calendar fa-2x features"></i> <span class="lead features">Scheduled Posts</span>
                    <p>Write posts and schedule the time and date you want them to appear.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-tags fa-2x features"></i> <span class="lead features">Tagging</span>
                    <p>Canvas allows you to tag posts for categorization and for grouping.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-fw fa-upload fa-2x features"></i> <span class="lead features">Uploading</span>
                    <p>File management and configuration come fully functional straight out of the box. Create folders and upload files or images.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-html5 fa-2x features"></i> <span class="lead features">Theming</span>
                    <p>Canvas utilizes custom LESS files so you can modify the theme to your own taste and preference.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-fighter-jet fa-2x features"></i> <span class="lead features">Simple Configuration</span>
                    <p>A single configuration file holds all of the necessary global variables to set in order to get you up and running in no time.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container-fluid">
            <div class="col-md-10 col-md-offset-1">
                <hr>
                <p class="text-muted" align="center">&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }} - By <a href="http://toddaustin.noip.me" target="_blank">Todd Austin</a>. All Rights Reserved</p>
            </div>
        </div>
    </footer>
@stop