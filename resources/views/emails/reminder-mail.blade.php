
@component('mail::message')
<img src="https://quickmann.app/images/bg-3.jpeg">

<br>
<br>
{!! nl2br($data['body']) ?? '' !!}

@endcomponent
