<div class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a href="#" class="navbar-brand"><img src="http://sass-lang.com/assets/img/logos/logo-b6e1ef6e.svg" style="height: 30px"></a>
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="navbar-collapse collapse" id="navbar-main">
      <ul class="nav navbar-nav">
        <li @if (Request::is('admin/post*')) class="active" @endif><a href="/admin/post"><i class="material-icons">format_size</i>&nbsp;&nbsp;Posts</a></li>
        <li @if (Request::is('admin/tag*')) class="active" @endif><a href="/admin/tag"><i class="material-icons">local_offer</i>&nbsp;&nbsp;Tags</a></li>
        <li @if (Request::is('admin/upload*')) class="active" @endif><a href="/admin/upload"><i class="material-icons">file_upload</i>&nbsp;&nbsp;Uploads</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/auth/logout"><i class="material-icons">exit_to_app</i>&nbsp;&nbsp;Logout</a></li>
      </ul>
    </div>
  </div>
</div>