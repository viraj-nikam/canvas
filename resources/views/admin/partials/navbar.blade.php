<div class="container">
    <ul class="nav nav-tabs">
      <li role="presentation" @if (Request::is('admin/post*')) class="active" @endif><a href="/admin/post"><i class="fa fa-fw fa-newspaper-o"></i> <span class="nav-copy">Posts</span></a></li>
      <li role="presentation" @if (Request::is('admin/tag*')) class="active" @endif><a href="/admin/tag"><i class="fa fa-fw fa-tags"></i> <span class="nav-copy">Tags</span></a></li>
      <li role="presentation" @if (Request::is('admin/upload*')) class="active" @endif><a href="/admin/upload"><i class="fa fa-fw fa-cloud-upload"></i> <span class="nav-copy">Uploads</span></a>
      </li>
      <li role="presentation"><a href="/blog" target="_blank"><i class="fa fa-fw fa-globe"></i> <span class="nav-copy">Visit Site</span></a></li>
      <li role="presentation"><a href="/auth/logout"><i class="fa fa-fw fa-sign-out"></i> <span class="nav-copy">Sign Out</span></a></li>
    </ul>
</div>