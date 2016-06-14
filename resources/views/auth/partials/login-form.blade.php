<form role="form" id="login" method="POST" action="{{ url('/auth/login') }}">
    {!! csrf_field() !!}
    <div class="form-group fg-line">
        <input type="email" class="form-control"
               name="email" value="{{ old('email') }}" placeholder="Email">
    </div>
    <div class="form-group fg-line">
        <input type="password" name="password" class="form-control"
               placeholder="Password">
    </div>

    <button type="submit" name="submit" class="btn btn-primary btn-block m-t-10">Sign in</button>
</form>