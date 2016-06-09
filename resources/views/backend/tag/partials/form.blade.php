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
      <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Meta Description">{{ $meta_description }}</textarea>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Layout</label>
      <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}" placeholder="Layout">
    </div>
</div>

<br>

<div class="form-group">
    <label class="radio radio-inline m-r-20">
        <input type="radio" name="reverse_direction" id="reverse_direction" @if (! $reverse_direction) checked="checked" @endif value="0">
        <i class="input-helper"></i>
        Normal
    </label>

    <label class="radio radio-inline m-r-20">
        <input type="radio" name="reverse_direction" @if ($reverse_direction) checked="checked" @endif value="1">
        <i class="input-helper"></i>
        Reverse
    </label>
</div>

<br>