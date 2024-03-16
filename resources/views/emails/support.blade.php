@component('mail::message')
# Hello,

We're reaching out to share some resources that you might find helpful. Please remember, it's okay to seek support.

@component('mail::button', ['url' => 'https://example.com/resources'])
View Resources
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent

