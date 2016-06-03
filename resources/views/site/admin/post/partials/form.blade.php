<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Title</label>
      <input type="text" class="form-control" name="title" id="title" value="{{ $title }}" placeholder="Title">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Subtitle</label>
      <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}" placeholder="Subtitle">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Page Image</label>
      <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()" alt="Image thumbnail" value="{{ $page_image }}" placeholder="Page Image">
    </div>
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
@if (empty($page_image))

    <span class="text-muted small">No Image Selected</span>

@else

    <img src="{{ page_image($page_image) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">

@endif

<br>
<br>

<div class="form-group">
    <div class="fg-line">
      <textarea id="editor" name="content" placeholder="Content">{{ $content }}</textarea>
    </div>
</div>









<hr>
<hr>
<hr>



















<div class="form-group">
    <div class="fg-line">
        <input type="text" class="form-control" placeholder="Input Default">
    </div>
</div>

<div class="form-group">
    <div class="fg-line">
        <input type="text" class="form-control input-lg" placeholder="Input Large">
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-4">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-4">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-4">
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-3">
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-3">
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-3">
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-3">
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-6">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="fg-line">
                <input type="text" class="form-control" placeholder="col-sm-6">
            </div>
        </div>
    </div>
</div>

<br/>
<p class="m-b-25 m-t-25 c-black f-500">Floating Label - Floating animation for label when
    Input feild is active.</p>

<div class="form-group fg-float">
    <div class="fg-line">
        <input type="text" class="input-sm form-control fg-input">
        <label class="fg-label">Input Small</label>
    </div>
</div>

<br>

<div class="form-group fg-float">
    <div class="fg-line">
        <input type="text" class="form-control fg-input">
        <label class="fg-label">Input Default</label>
    </div>
</div>

<br>

<div class="form-group fg-float">
    <div class="fg-line">
        <input type="text" class="input-lg form-control fg-input">
        <label class="fg-label">Input Large</label>
    </div>
</div>

<br/>
<p class="m-b-25 m-t-25 c-black f-500">Input Status - Focused and Disabled</p>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <div class="fg-line fg-toggled">
                <input type="text" class="form-control" value="This is Focused">
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <div class="fg-line disabled">
                <input type="text" class="form-control" value="This is Disabled" disabled>
            </div>
        </div>
    </div>
</div>
















<fieldset>

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