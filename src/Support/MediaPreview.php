<?php

namespace Matteomascellani\FilamentPreviewFiles\Support;

use Illuminate\Support\HtmlString;

class MediaPreview
{
    public static function hasMedia(?object $record, string $collection = 'attachments'): bool
    {
        if (! $record || ! method_exists($record, 'getMedia')) {
            return false;
        }

        if (method_exists($record, 'unsetRelation')) {
            $record->unsetRelation('media');
        }

        return $record->getMedia($collection)->isNotEmpty();
    }

    public static function renderCollection(
        ?object $record,
        string $collection = 'attachments',
        bool $showLabelLink = false,
        bool $showLabelText = true,
        string $wrapperClass = 'space-y-1',
    ): HtmlString {
        if (! $record || ! method_exists($record, 'getMedia')) {
            return new HtmlString('');
        }

        if (method_exists($record, 'unsetRelation')) {
            $record->unsetRelation('media');
        }

        $items = $record->getMedia($collection)->map(function ($media) use ($showLabelLink, $showLabelText) {
            return view('filament-preview-files::components.media-zoom-link', [
                'url' => method_exists($media, 'getUrl') ? $media->getUrl() : null,
                'mimeType' => (string) data_get($media, 'mime_type'),
                'label' => (string) data_get($media, 'name') . '.' . pathinfo((string) data_get($media, 'file_name'), PATHINFO_EXTENSION),
                'showLabelLink' => $showLabelLink,
                'showLabelText' => $showLabelText,
            ])->render();
        })->implode('');

        return new HtmlString('<div class="' . e($wrapperClass) . '">' . $items . '</div>');
    }
}
