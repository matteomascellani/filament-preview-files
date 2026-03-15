@php
    $isImage = str_starts_with((string) $mimeType, 'image/');
    $isPdf = $mimeType === 'application/pdf';
    $canZoom = $isImage || $isPdf;
    $linkClass = $linkClass ?? 'text-xs font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 underline';
@endphp

<div class="flex items-center gap-1">
    <a href="{{ $url }}" target="_blank" class="{{ $linkClass }}">
        {{ $label }}
    </a>

    @if ($canZoom)
        <x-filament::modal width="7xl" close-button>
            <x-slot name="trigger">
                <button
                    type="button"
                    class="inline-flex items-center justify-center w-4 h-4 rounded bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-600 dark:bg-white/10 dark:hover:bg-primary-500/20 dark:text-gray-400 dark:hover:text-primary-400 transition"
                    title="Zoom"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.739 5.739a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="heading">
                {{ $label }}
            </x-slot>

            @include('filament-preview-files::modals.media-zoom-content', [
                'url' => $url,
                'mimeType' => $mimeType,
                'label' => $label,
            ])
        </x-filament::modal>
    @else
        <a
            href="{{ $url }}"
            target="_blank"
            class="inline-flex items-center justify-center w-4 h-4 rounded bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-600 dark:bg-white/10 dark:hover:bg-primary-500/20 dark:text-gray-400 dark:hover:text-primary-400 transition"
            title="Apri file"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-7.5 3L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
        </a>
    @endif
</div>
