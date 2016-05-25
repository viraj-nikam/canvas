<fieldset>
  <div class="form-group">
    <div class="col-lg-10">
      <input type="text" class="form-control" name="title" autofocus id="title" value="{{ $title }}" placeholder="Title">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10">
      <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}" placeholder="Subtitle">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10">
      <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()" alt="Image thumbnail" value="{{ $page_image }}" placeholder="Page Image">
    </div>
    <script>
        function handle_image_change() {
            $("#page-image-preview").attr("src", function () {
                var value = $("#page_image").val();
                if (!value) {
                    value = {!! json_encode(config('blog.page_image')) !!};
                    if (value == null) {
                        value = '';
                    }
                }
                if (value.substr(0, 4) != 'http' && value.substr(0, 1) != '/') {
                    value = {!! json_encode(config('blog.uploads.webpath')) !!} +'/' + value;
                }
                return value;
            });
        }
    </script>
    <div class="visible-sm space-10"></div>
    <div class="col-md-4 text-right">
        @if (empty($page_image))

            <span class="text-muted small">No Image Selected</span>

        @else

            <img src="{{ page_image($page_image) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">

        @endif
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10">
      <textarea class="form-control" name="content" rows="8" id="content" style="resize: vertical" placeholder="Content">{{ $content }}</textarea>
      <p class="small"><strong>Supported content includes: Markdown, HTML5, CSS3</strong></p>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="publish_date" id="publish_date" type="text" value="{{ $publish_date }}" placeholder="Publish Date">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-10">
      <input class="form-control" name="publish_time" id="publish_time" type="text" value="{{ $publish_time }}" placeholder="Publish Time">
    </div>
  </div>

  <div class="form-group">
      <label for="inputDraft" class="col-lg-2 control-label">Draft</label>
      <div class="col-lg-10">
          <input {{ checked($is_draft) }} type="checkbox" name="is_draft">
      </div>
  </div>

  <div class="form-group">
      <label for="inputTags" class="col-lg-2 control-label">Tags</label>
      <div class="col-lg-10">
        <select name="tags[]" id="tags" class="form-control" multiple>
              @foreach ($allTags as $tag)
                  <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">{{ $tag }}</option>
              @endforeach
          </select>
      </div>
    </div>

  <div class="form-group">
      <div class="col-lg-10">
          <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}" placeholder="Layout">
      </div>
  </div>

  <div class="form-group">
      <div class="col-lg-10">
          <textarea class="form-control" name="meta_description" id="meta_description" rows="3" style="resize: vertical" placeholder="Meta Description">{{ $meta_description }}</textarea>
      </div>
  </div>
</fieldset>