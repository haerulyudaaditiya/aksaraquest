@component('mail::message')
{{-- Header --}}
{{-- Hapus logo dan teks Laravel --}}

{{-- Konten Email --}}
# {{ $greeting ?? 'Halo!' }}

@foreach ($introLines as $line)
{{ $line }}

@endforeach

@isset($actionText)
@php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
@endphp
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Penutup --}}
Salam hangat,<br>
{{ config('app.name') }}

{{-- Footer --}}
@isset($actionText)
@component('mail::subcopy')
Jika Anda mengalami kesulitan menekan tombol "{{ $actionText }}", salin dan tempel tautan di bawah ini ke peramban web Anda:
[{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
