<div class="card">
    <div class="card-header">
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}">Home</a></li>
            <li class="active">Settings</li>
        </ol>

        <h2>General Settings
            <small>Overview of configuration options for your site.</small>
        </h2>

        <ul class="actions">
            <li class="dropdown">
                <a href="" data-toggle="dropdown">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="">Refresh Settings</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="card-body card-padding">

        @include('shared.errors')

        @include('shared.success')

        @include('backend.settings.partials.form.settings')
    </div>
</div>