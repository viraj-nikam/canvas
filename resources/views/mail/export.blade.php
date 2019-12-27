@component('mail::message')
# Canvas

We’ve created an archive of the information you’ve shared on Canvas. You can download the zip file for the next 24 hours.

@component('mail::button', ['url' => $archive->url, 'color' => 'success'])
Download my archive
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
