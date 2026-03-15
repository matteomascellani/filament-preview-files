<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;

class MediaPreviewAction
{
    /**
     * Build a single reusable action that previews media and provides an open-file link.
     */
    public static function make(
        ?callable $urlResolver = null,
        ?callable $mimeResolver = null,
        ?callable $headingResolver = null,
        string $name = 'preview_media',
    ): Action {
        $getUrl = $urlResolver ?? fn ($record) => method_exists($record, 'getUrl') ? $record->getUrl() : null;
        $getMime = $mimeResolver ?? fn ($record) => (string) data_get($record, 'mime_type');
        $getHeading = $headingResolver ?? fn ($record) => (string) data_get($record, 'file_name', 'Preview');

        $view = (string) config('filament-preview-files.media_zoom.view', 'filament-preview-files::modals.media-zoom-content');
        $width = (string) config('filament-preview-files.media_zoom.modal_width', '7xl');

        return Action::make($name)
            ->label('Anteprima file')
            ->icon('heroicon-o-magnifying-glass-plus')
            ->iconButton()
            ->modalHeading(fn ($record) => $getHeading($record))
            ->modalContent(function ($record) use ($getUrl, $getMime, $getHeading, $view) {
                return view($view, [
                    'url' => $getUrl($record),
                    'mimeType' => $getMime($record),
                    'label' => $getHeading($record),
                    'showOpenLink' => true,
                ]);
            })
            ->modalWidth($width)
            ->modalSubmitAction(false)
            ->modalCancelAction(false)
            ->visible(fn ($record) =>
                Str::startsWith((string) $getMime($record), 'image/')
                || (string) $getMime($record) === 'application/pdf'
            );
    }
}
