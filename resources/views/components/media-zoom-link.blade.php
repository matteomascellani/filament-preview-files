@php
    /** @var \Illuminate\Database\Eloquent\Model|null $record */
    $record = $record ?? null;
    $collection = (string) ($collection ?? '');
    $heading = (string) ($heading ?? ucfirst($collection));
    $url = $url ?? null;

    // Prevent recursive includes: when URL is present we must render single-file mode.
    $isCollectionMode = blank($url) && $record && $collection !== '' && method_exists($record, 'getMedia');
@endphp

@if ($isCollectionMode)
    @php
        $items = $record->getMedia($collection);
    @endphp

    <div class="space-y-4">
        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $heading }}</p>

        @if (! $record?->exists)
            <p class="text-xs text-gray-500 dark:text-gray-400">Save the record first to view attachments.</p>
        @elseif ($items->isEmpty())
            <p class="text-xs text-gray-500 dark:text-gray-400">No attachments found.</p>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                        @foreach ($items as $media)
                            @php
                                $fileName = (string) ($media->name ?: $media->file_name);
                            @endphp

                            <tr class="align-middle">
                                <td class="px-3 py-2 text-gray-800 dark:text-gray-100">
                                    <span class="block truncate" title="{{ $fileName }}">{{ $fileName }}</span>
                                </td>
                                <td class="px-3 py-2 w-1 whitespace-nowrap">
                                    @include('filament-preview-files::components.media-zoom-link', [
                                        'url' => $media->getUrl(),
                                        'mimeType' => (string) ($media->mime_type ?? ''),
                                        'label' => $fileName,
                                        'showLabelText' => false,
                                        'showLabelLink' => false,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@else
    @php
        $hasUrl = filled($url ?? null);
        $isImage = str_starts_with((string) $mimeType, 'image/');
        $isPdf = $mimeType === 'application/pdf';
        $canZoom = $hasUrl && ($isImage || $isPdf);
        $linkClass = $linkClass ?? 'text-xs font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 underline';
        $showLabelLink = (bool) ($showLabelLink ?? true);
        $showLabelText = (bool) ($showLabelText ?? true);
        $useCompactButtons = ! $showLabelText;
    @endphp

    <div class="flex items-center gap-2">
        @if ($showLabelText)
            @if ($showLabelLink)
                @if ($hasUrl)
                    <a href="{{ $url }}" target="_blank" class="{{ $linkClass }}">
                        {{ $label }}
                    </a>
                @else
                    <span class="text-xs text-gray-700 dark:text-gray-300">{{ $label }}</span>
                @endif
            @else
                <span class="text-xs text-gray-700 dark:text-gray-300">{{ $label }}</span>
            @endif
        @endif

        @if ($canZoom)
            <x-filament::modal width="7xl" close-button>
                <x-slot name="trigger">
                    @if ($useCompactButtons)
                        <x-filament::button
                            type="button"
                            size="sm"
                            color="primary"
                            class="!px-2 !py-1 !text-xs !inline-flex !items-center !gap-1 !whitespace-nowrap"
                        >
                            <span class="inline-flex items-center gap-1 whitespace-nowrap">
                                <x-filament::icon icon="heroicon-o-magnifying-glass-plus" class="w-3.5 h-3.5 shrink-0" />
                                <span>Preview</span>
                            </span>
                        </x-filament::button>
                    @else
                        <button
                            type="button"
                            class="inline-flex items-center justify-center w-4 h-4 rounded bg-gray-100 hover:bg-primary-100 text-gray-600 hover:text-primary-600 dark:bg-white/10 dark:hover:bg-primary-500/20 dark:text-gray-400 dark:hover:text-primary-400 transition"
                            title="Zoom"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.739 5.739a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                            </svg>
                        </button>
                    @endif
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
        @endif

        @if ($hasUrl)
            @if ($useCompactButtons)
                <x-filament::button
                    tag="a"
                    href="{{ $url }}"
                    target="_blank"
                    size="sm"
                    color="primary"
                    class="!px-2 !py-1 !text-xs !inline-flex !items-center !gap-1 !whitespace-nowrap"
                >
                    <span class="inline-flex items-center gap-1 whitespace-nowrap">
                        <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="w-3.5 h-3.5 shrink-0" />
                        <span>Open</span>
                    </span>
                </x-filament::button>
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
        @else
            @if ($useCompactButtons)
                <x-filament::badge color="danger" size="sm">
                    N/A
                </x-filament::badge>
            @else
                <span
                    class="inline-flex items-center justify-center w-4 h-4 rounded bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-300"
                    title="Anteprima non disponibile"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m18.364 5.636-12.728 12.728m0-12.728 12.728 12.728" />
                    </svg>
                </span>
            @endif
        @endif
    </div>
@endif
