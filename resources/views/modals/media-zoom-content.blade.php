@php
    $isImage = str_starts_with((string) $mimeType, 'image/');
    $maxViewportHeight = 'calc(100vh - 12rem)';
@endphp

@if ($isImage)
    <div class="px-2 py-3 sm:px-4 sm:py-4" style="overflow: auto;">
        <div style="display:flex;align-items:center;justify-content:center;width:100%;max-height:{{ $maxViewportHeight }};overflow:auto;">
        <img
            src="{{ $url }}"
            alt="{{ $label ?? 'Media preview' }}"
            class="rounded-lg"
            style="display:block;max-width:100%;max-height:{{ $maxViewportHeight }};width:auto;height:auto;object-fit:contain;"
        >
        </div>
    </div>
@else
    <div class="px-2 py-3 sm:px-4 sm:py-4" style="overflow: auto;">
        <iframe
            src="{{ $url }}"
            title="{{ $label ?? 'Media preview' }}"
            class="block w-full rounded-lg border-0 bg-white"
            style="display:block;width:100%;height:{{ $maxViewportHeight }};max-height:{{ $maxViewportHeight }};"
        ></iframe>
    </div>
@endif
