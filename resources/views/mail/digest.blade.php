@component('mail::message')
# {{ __('canvas::mail.digest.summary') }} {{ $data['end_date'] }}

{{ __('canvas::mail.digest.from') }} {{ $data['start_date'] }} {{ __('canvas::mail.digest.to') }} {{ $data['end_date'] }}, {{ __('canvas::mail.digest.data') }}:

@component('mail::table')
|                                 |                               |
|---------------------------------|-------------------------------|
| **+{{ $data['total_views'] }}** | **+{{ $data['total_visits'] }}** |
| Views                           | Visits                        |
@endcomponent

@component('mail::table')
|                        | Visits                                    | Views                                    |
| ---------------------- | ----------------------------------------- | ----------------------------------------:|
@foreach($data['posts'] as $post)
| *{{ $post['title'] }}* | **+{{ number_format($post['visits']) }}** | **+{{ number_format($post['views']) }}** |
@endforeach
@endcomponent

@component('mail::button', ['url' => url(config('canvas.path'))])
{{ __('canvas::buttons.stats.index') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
