@if (Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="material-icons">check_circle</i>&nbsp;Success!</strong>
        {{ Session::get('success') }}
    </div>
@endif