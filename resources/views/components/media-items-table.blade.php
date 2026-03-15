@php
    $mediaItems = $mediaItems ?? collect();

    if (! $mediaItems instanceof \Illuminate\Support\Collection) {
        $mediaItems = collect($mediaItems);
    }
@endphp

@if ($mediaItems->isNotEmpty())
    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                @foreach ($mediaItems as $media)
                    @include('filament-preview-files::components.media-item-row', [
                        'media' => $media,
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
@endif
