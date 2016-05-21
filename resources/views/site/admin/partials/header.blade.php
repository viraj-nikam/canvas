<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="/admin" class="navbar-brand"><img src="{{ asset('images/canvas.svg') }}" style="height: 50px; margin-top: -9px"></a>
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-collapse collapse" id="navbar-main">
      <ul class="nav navbar-nav">
        <li @if (Request::is('admin/post*')) class="active" @endif><a href="/admin/post"><i class="material-icons">collections_bookmark</i>&nbsp;&nbsp;Posts</a></li>
        <li @if (Request::is('admin/tag*')) class="active" @endif><a href="/admin/tag"><i class="material-icons">local_offer</i>&nbsp;&nbsp;Tags</a></li>
        <li @if (Request::is('admin/upload*')) class="active" @endif><a href="/admin/upload"><i class="material-icons">cloud_upload</i>&nbsp;&nbsp;Uploads</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="material-icons">account_circle</i>&nbsp;&nbsp;{{ Auth::user()->display_name }} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li class="divider"></li>
            <li><a href="/auth/logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>