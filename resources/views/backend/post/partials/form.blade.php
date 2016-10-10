@if(Request::is('admin/post/create'))
<form class="keyboard-save" role="form" method="POST" id="postCreate" action="{{ route('admin.post.store') }}">
@else
<form class="keyboard-save" role="form" method="POST" id="postUpdate" action="{{ route('admin.post.update', $id) }}">
    <input type="hidden" name="_method" value="PUT">
@endif
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">

                    @include('shared.errors')
                    @include('shared.success')

                    <h2>Create a New Post
                        <br>
                        @if(Request::is('admin/post/create'))
                            <small>Set a page image to feature at the top of your blog post by specifying the image path relative to the uploads directory.</small>
                        @else
                            <small>Last edited on {{ $updated_at->format('M d, Y') }} at {{ $updated_at->format('g:i A') }}</small>
                        @endif
                    </h2>
                </div>
                <div class="card-body card-padding">
                    <br>

                    <div class="form-group">
                        <div class="fg-line">
                            <input type="text" class="form-control" name="title" id="title" value="{{ $title }}" placeholder="Title">
                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <div class="fg-line">
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ $slug }}" placeholder="URL Slug">
                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <div class="fg-line">
                            <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}" placeholder="Subtitle">
                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <div class="fg-line">
                            <textarea id="editor" name="content" placeholder="Content">{{ $content }}</textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h2>Publish</h2>
                </div>
                <div class="card-body card-padding">
                    <div class="form-group">
                        <div class="toggle-switch toggle-switch-demo" data-ts-color="blue">
                            <label for="is_draft" class="ts-label">Draft?</label>
                            <input {{ checked($is_draft) }} type="checkbox" name="is_draft">
                            <label for="is_draft" class="ts-helper"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-line">
                            <a type="button" class="btn btn-primary btn-icon-text btn-sm" href="{{ url('blog/' . $slug) }}" target="_blank">
                                <i class="zmdi zmdi-search"></i> Preview Changes
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-line">
                            <label>Published at</label>
                            <input class="form-control datetime-picker" name="published_at" id="published_at" type="text" value="{{ $published_at }}" placeholder="YYYY/MM/DD HH:MM:SS" data-mask="0000/00/00 00:00:00">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fg-line">
                            <label class="fg-label">Layout</label>
                            <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}" placeholder="Layout" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        @if(Request::is('admin/post/create'))
                            <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Publish</button>
                            &nbsp;
                            <a href="{{ url('admin/post') }}"><button type="button" class="btn btn-link">Cancel</button></a>
                        @else
                            <button type="submit" class="btn btn-primary btn-icon-text" name="action" value="continue">
                                <i class="zmdi zmdi-floppy"></i> Save
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-danger btn-icon-text" data-toggle="modal" data-target="#modal-delete">
                                <i class="zmdi zmdi-delete"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Tags</h2>
                </div>
                <div class="card-body card-padding">
                    <div class="form-group">
                        <div class="fg-line">
                            <select name="tags[]" id="tags" class="selectpicker" multiple>
                                @foreach ($allTags as $tag)
                                    <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>Featured Image</h2>
                </div>
                <div class="card-body card-padding">
                    <div class="form-group">
                        <div class="fg-line">
                            <div class="input-group">
                                <input type="text" class="form-control" name="page_image" id="page_image" alt="Image thumbnail" value="{{ $page_image }}" placeholder="Page Image" v-model="pageImage">
                                <span class="input-group-btn" style="margin-bottom: 11px">
                                    <button style="margin-bottom: -5px" type="button" class="btn btn-primary waves-effect" @click="openFromPageImage()">Select Image</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="visible-sm space-10"></div>

                    <div>
                        <img v-if="pageImage" class="img img-responsive" id="page-image-preview" style="margin-top: 3px; max-height:100px;" :src="pageImage">
                        <span v-else class="text-muted small">No Image Selected</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>SEO</h2>
                    <small>Meta descriptions are HTML attributes that provide concise explanations of the contents of web pages.</small>
                </div>
                <div class="card-body card-padding">
                    <div class="form-group">
                        <div class="fg-line">
                            <textarea class="form-control auto-size" name="meta_description" id="meta_description" style="resize: vertical" placeholder="Meta Description">{{ $meta_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>