@component('mail::message')
# Hey..

This is your password Change link!

@component('mail::button', ['url' => $url])
verification
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
