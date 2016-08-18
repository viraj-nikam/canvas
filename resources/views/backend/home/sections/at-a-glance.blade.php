<div class="card">
    <div class="card-header">
        <h2>At a Glance
            <small>Quick snapshot of your site:</small>
        </h2>
        <br>
        <ul class="getting-started">
            <li>
                @if($data['status'] === 1)
                    <i class="zmdi zmdi-globe-alt"></i> <span class="label label-success">Status: {{ strtoupper('Active') }}</span>
                @else
                    <i class="zmdi zmdi-globe-alt"></i> <span class="label label-warning">Status: {{ strtoupper('Maintenance Mode') }}</span>
                @endif
            </li>
            <li>
                <i class="zmdi zmdi-collection-bookmark"></i> <a href="{{ url('admin/post') }}">{{ count($data['posts']) }}{{ str_plural(' Post', count($data['posts'])) }}</a>
            </li>
            <li>
                <i class="zmdi zmdi-labels"></i> <a href="{{ url('admin/tag') }}">{{ count($data['tags']) }}{{ str_plural(' Tag', count($data['tags'])) }}</a>
            </li>
            <li>
                <i class="zmdi zmdi-disqus"></i> <a href="{{ url('https://github.com/austintoddj/canvas#advanced-options') }}">Disqus: {{ $data['disqus'] === 0 ? 'Disabled' : 'Enabled' }}</a>
            </li>
            <li>
                <i class="zmdi zmdi-trending-up"></i> <a href="{{ url('https://github.com/austintoddj/canvas#advanced-options') }}">Google Analytics: {{ $data['analytics'] === 0 ? 'Disabled' : 'Enabled' }}</a>
            </li>
        </ul>
        <hr>
        <small>Canvas is currently running <a href="https://laravel.com/docs/5.2" target="_blank">Laravel 5.2</a>.</small>
    </div>
</div>