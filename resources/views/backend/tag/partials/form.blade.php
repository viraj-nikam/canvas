<div class="form-group">
    <div class="col-md-8">
        <input type="text" class="form-control" name="title" id="title" value="{{ $title }}" placeholder="Title">
    </div>
</div>
<div class="form-group">
    <div class="col-md-8">
        <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}" placeholder="Subtitle">
    </div>
</div>
<div class="form-group">
    <div class="col-md-8">
        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Meta Description">{{ $meta_description }}</textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-4">
        <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}" placeholder="Layout">
    </div>
</div>
<div class="form-group">
    <label for="reverse_direction" class="col-md-3 control-label">Direction</label>
    <div class="col-md-7">
        <label class="radio-inline">
            <input type="radio" name="reverse_direction" id="reverse_direction" @if (! $reverse_direction) checked="checked" @endif value="0"> Normal
        </label>
        <label class="radio-inline">
            <input type="radio" name="reverse_direction" @if ($reverse_direction) checked="checked" @endif value="1"> Reversed
        </label>
    </div>
</div>