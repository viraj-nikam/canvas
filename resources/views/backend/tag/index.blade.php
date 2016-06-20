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

                        <h2>Manage Tags&nbsp;
                            <a href="/admin/tag/create" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Create a new tag"><i class="zmdi zmdi-plus-circle"></i></a>
                            <small>This page provides a comprehensive overview of all current blog tags. Click the edit link next to each tag to modify specific meta details or information.</small>
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
                                @if(count($data) >= 1)
                                    @foreach ($data as $tag)
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
                                @else
                                    <tr>
                                        <td>No tags yet.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @if(count($data) >= 1)
        @include('backend.tag.partials.datatable')
    @endif

    @if(Session::get('_new-tag'))
        @include('backend.tag.partials.new-tag-notification')
        {{ \Session::forget('_new-tag') }}
    @endif

    @if(Session::get('_delete-tag'))
        @include('backend.tag.partials.delete-tag-notification')
        {{ \Session::forget('_delete-tag') }}
    @endif
@stop