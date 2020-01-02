@component('mail::message')
# {{ __('canvas::mail.digest.summary') }} {{ $data['end_date'] }}

{{ __('canvas::mail.digest.from') }} {{ $data['start_date'] }} {{ __('canvas::mail.digest.to') }} {{ $data['end_date'] }}, {{ __('canvas::mail.digest.data') }}:

# {{ number_format($data['total_views']) }}

{{ __('canvas::mail.digest.views') }}

@component('mail::table')
|                | {{ __('canvas::mail.digest.views_this_week') }} |
| -------------- | -----------------------------------------------:|
@foreach($data['posts'] as $title => $views)
| *{{ $title }}* | **+{{ number_format($views) }}**                |
@endforeach
@endcomponent

@component('mail::button', ['url' => url(config('canvas.path'))])
{{ __('canvas::buttons.stats.index') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
