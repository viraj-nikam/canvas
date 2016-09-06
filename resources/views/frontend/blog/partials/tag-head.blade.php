@if (isset($tag->title))
    <p class="tag-link">Explore <a href="#">{{ $tag->title or '' }}</a></p>
    <p class="tag-subtitle">- {{ $tag->subtitle }} -</p>
@endif