@php
    $level = $level ?? 'primary';
    $greeting = $greeting ?? null;
    $introLines = $introLines ?? [];
    $outroLines = $outroLines ?? [];
    $actionText = $actionText ?? null;
    $actionUrl = $actionUrl ?? null;
    $displayableActionUrl = $displayableActionUrl ?? null;
    $salutation = $salutation ?? null;
@endphp

<x-mail::message>

@if (! empty($greeting))
# {{ $greeting }}
@else
    @if ($level === 'error')
        # @lang('Whoops!')
    @else
        # @lang('Hello!')
    @endif
@endif

@foreach ($introLines as $line)
{{ $line }}

@endforeach

@isset($actionText)
    @php
        $color = in_array($level, ['success','error']) ? $level : 'primary';
    @endphp

    <x-mail::button :url="$actionUrl" :color="$color">
        {{ $actionText }}
    </x-mail::button>
@endisset

@foreach ($outroLines as $line)
{{ $line }}

@endforeach

@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),
{{ config('app.name') }}
@endif

@isset($actionText)
    <x-mail::subcopy>
        @lang(
            "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
            'into your web browser:',
            ['actionText' => $actionText]
        )
        <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
    </x-mail::subcopy>
@endisset

</x-mail::message>
