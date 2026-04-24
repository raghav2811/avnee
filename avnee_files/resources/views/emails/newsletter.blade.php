@component('mail::message')
# {{ $subject_line }}

{!! nl2br(e($body_content)) !!}

---

*You're receiving this because you subscribed to AVNEE Collections updates.*

@component('mail::button', ['url' => config('app.url') . '/newsletter/unsubscribe?email={{ $email ?? "" }}', 'color' => 'red'])
Unsubscribe
@endcomponent

Thanks,<br>
**AVNEE Collections**
@endcomponent
