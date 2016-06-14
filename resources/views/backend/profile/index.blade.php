@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Profile</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container container-alt">

                <div class="block-header">
                    <h2>{{ Auth::user()->display_name }}
                        <small>{{ Auth::user()->job }}, {{ Auth::user()->city }}, {{ Auth::user()->state }}</small>
                    </h2>
                </div>

                <div class="card" id="profile-main">
                    <div class="pm-overview c-overflow">

                        <div class="pmo-pic">
                            <div class="p-relative">

                                <img class="img-responsive" src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?d=identicon&s=500">

                                <div class="dropdown pmop-message">
                                    <a href="mailto:{{ Auth::user()->email }}" target="_blank" class="btn bgm-white btn-float z-depth-1">
                                        <i class="zmdi zmdi-email"></i>
                                    </a>
                                </div>
                            </div>


                            <div class="pmo-stat">
                                <h2 class="m-0 c-white">{{ Auth::user()->first_name }}</h2>
                                Member since {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Auth::user()->created_at)->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="pmo-block pmo-contact hidden-xs">
                            <h2>Contact</h2>

                            <ul>
                                <li><i class="zmdi zmdi-phone"></i> {{ Auth::user()->phone }}</li>
                                <li><i class="zmdi zmdi-email"></i> {{ Auth::user()->email }}</li>
                                <li><i class="zmdi zmdi-twitter"></i> {{ '@' . config('blog.twitter') }}</li>
                                <li><i class="zmdi zmdi-facebook-box"></i> facebook.com/{{ config('blog.facebook') }} </li>
                                <li>
                                    <i class="zmdi zmdi-pin"></i>
                                    <address class="m-b-0 ng-binding">
                                        {{ Auth::user()->address }},<br>
                                        {{ Auth::user()->city }},<br>
                                        {{ Auth::user()->state }}
                                    </address>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pm-body clearfix">
                        <ul class="tab-nav tn-justified">
                            <li class="active"><a href="/admin/profile">Profile</a></li>
                            <li><a href="/admin/profile/{{ Auth::user()->id }}/edit">Settings</a></li>
                        </ul>


                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-equalizer m-r-10"></i> Summary</h2>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view">
                                    {{ Auth::user()->bio }}
                                </div>
                            </div>
                        </div>

                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view">
                                    <dl class="dl-horizontal">
                                        <dt>Full Name</dt>
                                        <dd>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name}}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Gender</dt>
                                        <dd>{{ Auth::user()->gender }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Birthday</dt>
                                        <dd>{{ \Carbon\Carbon::createFromFormat('Y-m-d', Auth::user()->birthday)->format('M d, Y') }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Martial Status</dt>
                                        <dd>{{ Auth::user()->relationship }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-phone m-r-10"></i> Contact Information</h2>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view">
                                    <dl class="dl-horizontal">
                                        <dt>Mobile Phone</dt>
                                        <dd>{{ Auth::user()->phone }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Email Address</dt>
                                        <dd>{{ Auth::user()->email }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Twitter</dt>
                                        <dd>{{ '@' . config('blog.twitter') }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Facebook</dt>
                                        <dd>{{ config('blog.facebook') }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>Address</dt>
                                        <dd>{{ config('blog.address') }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>City</dt>
                                        <dd>{{ config('blog.city') }}</dd>
                                    </dl>
                                    <dl class="dl-horizontal">
                                        <dt>State</dt>
                                        <dd>{{ config('blog.state') }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop
