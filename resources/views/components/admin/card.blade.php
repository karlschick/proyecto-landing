@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition']) }}>
    @if($title)
        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $title }}</h3>
    @endif

    {{ $slot }}
</div>
