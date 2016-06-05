@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Edit Post</title>
@stop

@section('content')
    <section id="main">
        @include('site.admin.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li class="active"><a href="/admin/post">Posts</a></li>
                            <li class="active">Edit Post</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Posts</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')
                        @include('shared.success')

                        <h2>Edit <em>{{ $title }}</em>
                        </h2>
                    </div>
                    <div class="card-body card-padding">

                        <form role="form" method="POST" action="{{ route('admin.post.update', $id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            @include('site.admin.post.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-outline" name="action" value="continue">
                                    <i class="zmdi zmdi-floppy"></i>&nbsp;&nbsp;Save - Continue
                                </button>&nbsp;
                                <button type="submit" class="btn btn-success btn-outline" name="action" value="finished">
                                    <i class="zmdi zmdi-floppy"></i>&nbsp;&nbsp;Save - Finished
                                </button>&nbsp;
                                <button type="button" class="btn btn-danger btn-outline" data-toggle="modal" data-target="#modal-delete">
                                    <i class="zmdi zmdi-delete"></i>&nbsp;&nbsp;Delete
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </section>

    {{-- Confirm Delete --}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Delete this post?</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this post?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.post.destroy', $id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-outline">
                            <i class="zmdi zmdi-delete"></i>&nbsp;&nbsp;Delete Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('unique-js')
    <script type="text/javascript">
        $(document).ready(function(){
          $('.publish_date').mask('00/00/0000 00:00:00');
        });
        $('#editor').summernote({
            placeholder: 'Content',
            height: 300,
        });
    </script>
@stop