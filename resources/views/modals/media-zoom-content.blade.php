@php
    $isImage = str_starts_with((string) $mimeType, 'image/');
    $showOpenLink = (bool) ($showOpenLink ?? false);
@endphp

<div class="flex min-h-0 flex-col">
    @if ($showOpenLink)
        <div class="px-2 pb-2 sm:px-4">
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

    <div class="px-2 py-2 sm:px-4 sm:py-3" style="overflow: hidden;">
        <div
            class="w-full overflow-hidden rounded-lg border border-gray-200/70 dark:border-white/10"
            style="height: min(75vh, 900px); max-height: min(75vh, 900px);"
        >
        @if ($isImage)
            <div class="flex h-full w-full items-center justify-center bg-gray-50 dark:bg-gray-950/40">
                <img
                    src="{{ $url }}"
                    alt="{{ $label ?? 'Media preview' }}"
                    class="block"
                    style="display:block;width:auto;height:auto;max-width:100%;max-height:100%;object-fit:contain;object-position:center;"
                >
            </div>
        @else
            <iframe
                src="{{ $url }}"
                title="{{ $label ?? 'Media preview' }}"
                class="block h-full w-full border-0 bg-white"
                style="display:block;width:100%;height:100%;"
            ></iframe>
        @endif
        </div>
    </div>
</div>
