@php
    /** @var \Illuminate\Database\Eloquent\Model|null $record */
    $record = $record ?? null;
    $collection = (string) ($collection ?? 'images');
    $heading = (string) ($heading ?? ucfirst($collection));

    $items = collect();
    if ($record?->exists && method_exists($record, 'getMedia')) {
        $items = $record->getMedia($collection);
    }
@endphp

<div class="space-y-4">
    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $heading }}</p>

    @if (! $record?->exists)
        <p class="text-xs text-gray-500 dark:text-gray-400">Save the record first to view attachments.</p>
    @elseif ($items->isEmpty())
        <p class="text-xs text-gray-500 dark:text-gray-400">No attachments found.</p>
    @else
        <div class="flex flex-wrap gap-2">
            @foreach ($items as $media)
                @php
                    $url = $media->getUrl();
                    $mimeType = (string) ($media->mime_type ?? '');
                    $label = (string) ($media->name ?: $media->file_name);
                    $extension = strtolower((string) ($media->extension ?: pathinfo((string) $media->file_name, PATHINFO_EXTENSION)));
                    $displayName = $label;

                    if ($extension !== '' && ! str_ends_with(strtolower($displayName), '.' . $extension)) {
                        $displayName .= '.' . $extension;
                    }

                    $hasUrl = filled($url);
                    $isImage = str_starts_with($mimeType, 'image/');
                    $isPdf = $mimeType === 'application/pdf';
                    $canZoom = $hasUrl && ($isImage || $isPdf);
                @endphp

                <div class="inline-flex max-w-full items-center gap-2 px-1 py-1">
                    <span class="max-w-64 truncate text-sm font-medium text-gray-800 dark:text-gray-100" title="{{ $displayName }}">
                        {{ $displayName }}
                    </span>

                    <div class="shrink-0 flex items-center gap-2">
                        @if ($canZoom)
                            <x-filament::modal width="7xl" close-button>
                                <x-slot name="trigger">
                                    <x-filament::button
                                        type="button"
                                        size="sm"
                                        color="success"
                                        icon="heroicon-o-magnifying-glass-plus"
                                        class="!px-2 !py-1 !text-xs"
                                    >
                                        Preview
                                    </x-filament::button>
                                </x-slot>

                                <x-slot name="heading">
                                    {{ $label }}
                                </x-slot>

                                <div class="p-2 sm:p-4">
                                    @if ($isImage)
                                        <div class="flex items-center justify-center rounded-lg border border-gray-200/70 bg-gray-50 dark:border-white/10 dark:bg-gray-950/40" style="height: min(75vh, 900px);">
                                            <img
                                                src="{{ $url }}"
                                                alt="{{ $label }}"
                                                class="max-h-full max-w-full object-contain"
                                                loading="lazy"
                                            >
                                        </div>
                                    @else
                                        <div class="overflow-hidden rounded-lg border border-gray-200/70 dark:border-white/10" style="height: min(75vh, 900px);">
                                            <iframe
                                                src="{{ $url }}"
                                                title="{{ $label }}"
                                                class="h-full w-full border-0 bg-white"
                                            ></iframe>
                                        </div>
                                    @endif
                                </div>
                            </x-filament::modal>
                        @endif

                        @if ($hasUrl)
                            <x-filament::button
                                tag="a"
                                href="{{ $url }}"
                                target="_blank"
                                size="sm"
                                color="success"
                                icon="heroicon-o-arrow-top-right-on-square"
                                class="!px-2 !py-1 !text-xs"
                            >
                                Open
                            </x-filament::button>
                        @else
                            <x-filament::badge color="danger" size="sm">
                                N/A
                            </x-filament::badge>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
