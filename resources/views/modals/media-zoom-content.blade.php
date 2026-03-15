@php
    $isImage = str_starts_with((string) $mimeType, 'image/');
    $showOpenLink = (bool) ($showOpenLink ?? false);
@endphp

@if ($showOpenLink)
    <div class="px-2 pt-2 sm:px-4">
        <a
            href="{{ $url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 hover:underline dark:text-primary-400"
        >
            Apri file
        </a>
    </div>
@endif

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
