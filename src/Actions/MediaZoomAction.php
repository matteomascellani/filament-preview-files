<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

use Filament\Actions\Action;
use Illuminate\Support\Str;

class MediaZoomAction
{
    /**
     * Build a reusable Filament table action that previews image/PDF files in a modal.
     */
    public static function make(
        ?callable $urlResolver = null,
        ?callable $mimeResolver = null,
        ?callable $headingResolver = null,
        string $name = 'zoom',
    ): Action {
        $getUrl = $urlResolver ?? fn ($record) => method_exists($record, 'getUrl') ? $record->getUrl() : null;
        $getMime = $mimeResolver ?? fn ($record) => (string) data_get($record, 'mime_type');
        $getHeading = $headingResolver ?? fn ($record) => (string) data_get($record, 'file_name', 'Preview');

        $label = (string) config('filament-preview-files.media_zoom.label', 'Zoom');
        $view = (string) config('filament-preview-files.media_zoom.view', 'filament-preview-files::modals.media-zoom-content');
        $width = (string) config('filament-preview-files.media_zoom.modal_width', '7xl');

        return Action::make($name)
            ->label($label)
            ->icon('heroicon-o-magnifying-glass-plus')
            ->iconButton()
            ->modalHeading(fn ($record) => $getHeading($record))
            ->modalContent(function ($record) use ($getUrl, $getMime, $getHeading, $view) {
                return view($view, [
                    'url' => $getUrl($record),
                    'mimeType' => $getMime($record),
                    'label' => $getHeading($record),
                ]);
            })
            ->modalWidth($width)
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->visible(fn ($record) =>
                filled($getUrl($record))
                && (
                    Str::startsWith((string) $getMime($record), 'image/')
                    || (string) $getMime($record) === 'application/pdf'
                )
            );
    }
}
