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
                    <h2>{{ $data['display_name'] }}
                        <small>{{ $data['job'] }}, {{ $data['city'] }}, {{ $data['state'] }}</small>
                    </h2>
                </div>

                <div class="card" id="profile-main">
                    <div class="pm-overview c-overflow">

                        <div class="pmo-pic">
                            <div class="p-relative">

                                <img class="img-responsive" src="//www.gravatar.com/avatar/{{ md5($data['email']) }}?d=identicon&s=500">

                                <div class="dropdown pmop-message">
                                    <a href="mailto:{{ $data['email'] }}" target="_blank" class="btn bgm-white btn-float z-depth-1">
                                        <i class="zmdi zmdi-email"></i>
                                    </a>
                                </div>
                            </div>


                            <div class="pmo-stat">
                                <h2 class="m-0 c-white">{{ $data['first_name'] }}</h2>
                                Member since {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['created_at'])->format('M d, Y') }}
                            </div>
                        </div>

                        <div class="pmo-block pmo-contact hidden-xs">
                            <h2>Contact</h2>

                            <ul>
                                <li><i class="zmdi zmdi-phone"></i> {{ $data['phone'] }}</li>
                                <li><i class="zmdi zmdi-email"></i> {{ $data['email'] }}</li>
                                <li><i class="zmdi zmdi-twitter"></i> {{ '@' . $data['twitter'] }}</li>
                                <li><i class="zmdi zmdi-facebook-box"></i> facebook.com/{{ $data['facebook'] }} </li>
                                <li>
                                    <i class="zmdi zmdi-pin"></i>
                                    <address class="m-b-0 ng-binding">
                                        {{ $data['address'] }},<br>
                                        {{ $data['city'] }},<br>
                                        {{ $data['state'] }}
                                    </address>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="pm-body clearfix">
                        <ul class="tab-nav tn-justified">
                            <li class="active"><a href="/admin/profile">Profile</a></li>
                            <li><a href="/admin/profile/{{ $data['id'] }}/edit">Settings</a></li>
                        </ul>

                        @if(isset($data['bio']))
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-equalizer m-r-10"></i> Summary</h2>
                                </div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        {{ $data['bio'] }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view">
                                    <dl class="dl-horizontal">
                                        <dt>Full Name</dt>
                                        <dd>{{ $data['first_name'] . ' ' . $data['last_name']}}</dd>
                                    </dl>
                                    @if(isset($data['gender']))
                                        <dl class="dl-horizontal">
                                            <dt>Gender</dt>
                                            <dd>{{ $data['gender'] }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['birthday']))
                                        <dl class="dl-horizontal">
                                            <dt>Birthday</dt>
                                            <dd>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data['birthday'])->format('M d, Y') }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['relationship']))
                                        <dl class="dl-horizontal">
                                            <dt>Martial Status</dt>
                                            <dd>{{ $data['relationship'] }}</dd>
                                        </dl>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pmb-block">
                            <div class="pmbb-header">
                                <h2><i class="zmdi zmdi-phone m-r-10"></i> Contact Information</h2>
                            </div>
                            <div class="pmbb-body p-l-30">
                                <div class="pmbb-view">
                                    @if(isset($data['phone']))
                                        <dl class="dl-horizontal">
                                            <dt>Mobile Phone</dt>
                                            <dd>{{ $data['phone'] }}</dd>
                                        </dl>
                                    @endif
                                    <dl class="dl-horizontal">
                                        <dt>Email Address</dt>
                                        <dd>{{ $data['email'] }}</dd>
                                    </dl>
                                    @if(isset($data['twitter']))
                                        <dl class="dl-horizontal">
                                            <dt>Twitter</dt>
                                            <dd>{{ '@' . $data['twitter'] }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['facebook']))
                                        <dl class="dl-horizontal">
                                            <dt>Facebook</dt>
                                            <dd>{{ $data['facebook'] }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['address']))
                                        <dl class="dl-horizontal">
                                            <dt>Address</dt>
                                            <dd>{{ $data['address'] }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['city']))
                                        <dl class="dl-horizontal">
                                            <dt>City</dt>
                                            <dd>{{ $data['city'] }}</dd>
                                        </dl>
                                    @endif
                                    @if(isset($data['state']))
                                        <dl class="dl-horizontal">
                                            <dt>State</dt>
                                            <dd>{{ $data['state'] }}</dd>
                                        </dl>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop
