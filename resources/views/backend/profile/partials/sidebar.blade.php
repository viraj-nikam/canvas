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
            @if(isset($data['phone']))
                <li><i class="zmdi zmdi-phone"></i> {{ $data['phone'] }}</li>
            @endif
            <li><i class="zmdi zmdi-email"></i> <a href="mailto:{{ $data['email'] }}" target="_blank">{{ $data['email'] }}</a></li>
            @if(isset($data['twitter']))
                <li><i class="zmdi zmdi-twitter-box"></i> <a href="http://twitter.com/{{ $data['twitter'] }}" target="_blank">{{'@'.$data['twitter'] }}</a></li>
            @endif
            @if(isset($data['facebook']))
                <li><i class="zmdi zmdi-facebook-box"></i> <a href="http://facebook.com/{{ $data['facebook'] }}" target="_blank">{{ $data['facebook'] }}</a></li>
            @endif
            @if(isset($data['github']))
                <li><i class="zmdi zmdi-github-box"></i> <a href="http://github.com/{{ $data['facebook'] }}" target="_blank">{{ $data['github'] }}</a></li>
            @endif
            <li>
                @if(isset($data['address']) || isset($data['city']) || isset($data['state']))
                    <i class="zmdi zmdi-pin"></i>
                @endif
                <address class="m-b-0 ng-binding">
                    @if(isset($data['address']))
                        {{ $data['address'] }},<br>
                    @endif
                    @if(isset($data['city']))
                        {{ $data['city'] }},<br>
                    @endif
                    @if(isset($data['state']))
                        {{ $data['state'] }}
                    @endif
                </address>
            </li>
        </ul>
    </div>
</div>