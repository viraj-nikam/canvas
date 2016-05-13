@extends('landing')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <h1 class="title">Canvas</h1>
                <p class="lead"><em>A Minimal Blogging Application For Developers.</em></p>
                <p>Canvas is a minimalistic blogging application for developers. Canvas attempts to make blogging simple and enjoyable by utilizing the latest technologies and keeping the administration as simple as possible with the primary focus on writing.</p>
                <br />
                <center>
                    <a href="blog" class="btn btn-default btn-outline btn-sm"><i class="fa fa-fw fa-rss"></i> Blog</a>
                    <a href="admin" class="btn btn-default btn-outline btn-sm"><i class="fa fa-fw fa-sign-in"></i> Admin</a>
                    <a href="http://github.com/austintoddj/canvas" target="_blank" class="btn btn-outline btn-default btn-sm"><i class="fa fa-fw fa-github"></i> Download from GitHub</a>
                </center>
            </div>
            <div class="col-md-5">
                <img src="{{ asset('images/laptop.gif') }}" width="650" class="laptop img-responsive">
            </div>
        </div>
    </div>

    <div class="container-fluid feature-block">
        <div class="col-md-10 col-md-offset-1">
            <div class="row row-1">
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
            <div class="row row-2">
                <div class="col-md-4">
                    <i class="fa fa-fw fa-upload fa-2x features"></i> <span class="lead features">Uploading</span>
                    <p>File management and configuration come fully functional straight out of the box. Create folders and upload files or images.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-html5 fa-2x features"></i> <span class="lead features">Theming</span>
                    <p>Canvas utilizes custom LESS files so you can modify the theme to your own taste and preference.</p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-fw fa-cogs fa-2x features"></i> <span class="lead features">Simple Configuration</span>
                    <p>A single configuration file holds all of the necessary global variables to set in order to get you up and running in no time.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container-fluid">
            <div class="col-md-10 col-md-offset-1">
                <hr>
                <p class="text-muted" align="center">&copy; {{ \Carbon\Carbon::today()->format('Y') }} {{ config('blog.title') }}. All Rights Reserved</p>
            </div>
        </div>
    </footer>
@stop