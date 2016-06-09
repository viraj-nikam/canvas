@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Tags</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li class="active">Tags</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Tags</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')
                        @include('shared.success')

                        <h2>Manage Tags <a href="/admin/tag/create" data-toggle="tooltip" data-placement="right" title="" data-original-title="Create a New Tag"><i class="zmdi zmdi-plus-circle"></i></a>
                            <small>This page provides a comprehensive overview of all current blog tags. Click the edit or preview links next to each tag to modify specific meta details or information.</small>
                        </h2>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table-tags" class="table table-condensed table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="title" data-order="desc">Title</th>
                                    <th data-column-id="subtitle">Subtitle</th>
                                    <th data-column-id="layout">Layout</th>
                                    <th data-column-id="direction">Direction</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->title }}</td>
                                        <td class="hidden-sm">{{ $tag->subtitle }}</td>
                                        <td class="hidden-md">{{ $tag->layout }}</td>
                                        <td class="hidden-sm">
                                            @if ($tag->reverse_direction)
                                                Reverse
                                            @else
                                                Normal
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>







<!--<div class="row">
        <div class="col-sm-12">
            @include('shared.errors')
            @include('shared.success')
            <div class="table-responsive">
                <table id="tags-table" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Title</th>
                        <th class="hidden-sm">Subtitle</th>
                        <th class="hidden-md">Meta Description</th>
                        <th class="hidden-md">Layout</th>
                        <th class="hidden-sm">Direction</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{ $tag->tag }}</td>
                                <td>{{ $tag->title }}</td>
                                <td class="hidden-sm">{{ $tag->subtitle }}</td>
                                <td class="hidden-md">{{ $tag->meta_description }}</td>
                                <td class="hidden-md">{{ $tag->layout }}</td>
                                <td class="hidden-sm">
                                    @if ($tag->reverse_direction)
                                        Reverse
                                    @else
                                        Normal
                                    @endif
                                </td>
                                <td>
                                    <a href="/admin/tag/{{ $tag->id }}/edit" class="btn btn-xs btn-primary btn-outline"><i class="material-icons">mode_edit</i>&nbsp;&nbsp;Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
@stop

@section('unique-js')
    @include('backend.tag.partials.datatable')
@stop