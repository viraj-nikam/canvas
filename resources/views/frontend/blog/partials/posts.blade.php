@foreach ($posts as $post)
    <div class="post-preview">
        <h2 class="post-title">
            <a href="{{ $post->url($tag) }}">{{ $post->title }}</a>
        </h2>
        <p class="post-meta">
            {{ $post->published_at->diffForHumans() }}
            @unless ($post->tags->isEmpty())
                in {!! implode(', ', $post->tagLinks()) !!}
            @endunless
        </p>
        <p id="postSubtitle">
            {{ $post->subtitle }}
        </p>
        <p><a href="{{ $post->url($tag) }}">READ MORE...</a></p>
    </div>
    <hr>
@endforeach