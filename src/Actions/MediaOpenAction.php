<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

use Filament\Tables\Actions\Action;

class MediaOpenAction
{
    /**
     * Build a reusable Filament table action that opens the media in a new tab.
     */
    public static function make(
        ?callable $urlResolver = null,
        string $name = 'open',
    ): Action {
        $getUrl = $urlResolver ?? fn ($record) => method_exists($record, 'getUrl') ? $record->getUrl() : null;

        return Action::make($name)
            ->label('Apri file')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->visible(fn ($record) => filled($getUrl($record)))
            ->url(fn ($record) => $getUrl($record), shouldOpenInNewTab: true);
    }
}
