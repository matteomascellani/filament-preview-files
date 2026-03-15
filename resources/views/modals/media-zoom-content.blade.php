@php
    $isImage = str_starts_with((string) $mimeType, 'image/');
@endphp

@if ($isImage)
    <div class="px-2 py-3 sm:px-4 sm:py-4 overflow-auto">
        <div class="flex items-center justify-center w-full max-h-[calc(100vh-12rem)] overflow-auto">
        <img
            src="{{ $url }}"
            alt="{{ $label ?? 'Media preview' }}"
            class="rounded-lg block max-w-full max-h-[calc(100vh-12rem)] w-auto h-auto object-contain"
        >
        </div>
    </div>
@else
    <div class="px-2 py-3 sm:px-4 sm:py-4 overflow-auto">
        <iframe
            src="{{ $url }}"
            title="{{ $label ?? 'Media preview' }}"
            class="block w-full rounded-lg border-0 bg-white h-[calc(100vh-12rem)] max-h-[calc(100vh-12rem)]"
        ></iframe>
    </div>
@endif
