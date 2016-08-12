@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Tools</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="block-header">
                    <h2>Site Details
                        <small>
                            <i class="zmdi zmdi-dns"></i>&nbsp;&nbsp;{{ strtoupper($data['host']) }} ({{ $data['ip'] }})&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="zmdi zmdi-time"></i>&nbsp;&nbsp;{{ strtoupper($data['timezone']) }}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="zmdi zmdi-circle" @if($data['status'] === 'Active') style="color: #4CAF50" @else style="color: #FF9800;" @endif></i>&nbsp;&nbsp;{{ strtoupper($data['status']) }}
                        </small>
                    </h2>
                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="">Refresh Tools</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Maintenance Mode
                            <small>Enable or disable maintenance mode for your site. Once activated, all public traffic
                                will see a <em>Be Back Soon</em> page. As an logged in user, you will
                                still have full access the administrative area of the blog. Once your changes have been made,
                                make the site active again by disabling maintenance mode.
                            </small>
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        @if($data['status'] === 'Active')
                            <a href="{{ url('admin/tools/enable_maintenance_mode') }}">
                                <button class="btn btn-primary btn-icon-text">
                                    <i class="zmdi zmdi-alert-octagon"></i> Enable Maintenance Mode
                                </button>
                            </a>
                        @else
                            <a href="{{ url('admin/tools/disable_maintenance_mode') }}">
                                <button class="btn btn-warning btn-icon-text">
                                    <i class="zmdi zmdi-alert-octagon"></i> Disable Maintenance Mode
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Export Data
                            <small>When you click the button below Canvas will create a directory of CSV files for you
                                to save to your
                                computer. This archive will contain all the posts, tags, user information and relations
                                in the system.
                                Once the download has completed, you can use it to easily import into another Canvas
                                installation.
                            </small>
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        <a href="{{ url('admin/tools/download_archive') }}">
                            <button class="btn btn-primary btn-icon-text">
                                <i class="zmdi zmdi-archive"></i> Download Archive
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Search Index
                            <small>Last run on {{ date('M d, Y', $data['indexModified']) }}
                                at {{ date('g:i A', $data['indexModified']) }}</small>
                            <small>Here you can manually re-run a full index of the posts and tags currently in the
                                system.
                                This will trigger an overwrite of the existing index, replacing the data and forcing the
                                system to rebuild.
                            </small>
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        <a>
                            <button class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#reset-index">
                                <i class="zmdi zmdi-refresh-alt"></i> Reset Index
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>Application Cache
                            <small>Caching data improves performance, but may cause problems while troubleshooting new
                                features or theme styles if outdated information has been cached. To refresh all cached
                                data on your site, click the button below. <em><strong>Warning</strong>: high-traffic sites will
                                    experience performance slowdowns
                                    while cached data is rebuilt.</em>
                            </small>
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        <a>
                            <button class="btn btn-primary btn-icon-text" data-toggle="modal" data-target="#cache-clear">
                                <i class="zmdi zmdi-delete"></i> Clear Cache
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </section>

    @include('backend.tools.partials.modals.reset-index')
    @include('backend.tools.partials.modals.cache-clear')
@stop

@section('unique-js')
    @if(Session::get('_reset-index'))
        @include('backend.tools.partials.notifications.reset-index')
        {{ \Session::forget('_reset-index') }}
    @endif

    @if(Session::get('_cache-clear'))
        @include('backend.tools.partials.notifications.cache-clear')
        {{ \Session::forget('_cache-clear') }}
    @endif

    @if(Session::get('_enable-maintenance-mode'))
        @include('backend.tools.partials.notifications.enable-maintenance-mode')
        {{ \Session::forget('_enable-maintenance-mode') }}
    @endif

    @if(Session::get('_disable-maintenance-mode'))
        @include('backend.tools.partials.notifications.disable-maintenance-mode')
        {{ \Session::forget('_disable-maintenance-mode') }}
    @endif
@stop