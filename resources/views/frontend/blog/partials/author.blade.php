@if(!empty($user->github) || !empty($user->twitter) || !empty($user->facebook))
    <div class="author">
        <img class="img-responsive img-circle author-img" src="//www.gravatar.com/avatar/{{ md5($user->email) }}?d=identicon&s=150">
        <h5><strong>{{ $user->first_name .  ' ' . $user->last_name }}</strong>
            <br>
            <br>
            <span class="text-muted author-bio">{{ $user->bio }}</span>
            <br>
            <br>
            @if (!empty($user->twitter))
                <a href="http://twitter.com/{{ $user->twitter }}" target="_blank"><i class="fa fa-fw fa-twitter author-social"></i></a>
            @endif
            &nbsp;
            @if (!empty($user->facebook))
                <a href="http://facebook.com/{{ $user->facebook }}" target="_blank"><i class="fa fa-fw fa-facebook author-social"></i></a>
            @endif
            &nbsp;
            @if (!empty($user->github))
                <a href="http://github.com/{{ $user->github }}" target="_blank"><i class="fa fa-fw fa-github author-social"></i></a>
            @endif
            &nbsp;
            @if(isset($user->linkedin) && strlen($user->linkedin))
                <a href="http://linkedin.com/{{ $user->linkedin }}" target="_blank" id="social"><i class="fa fa-fw fa-linkedin author-social"></i></a>
            @endif
        </h5>
    </div>
@endif