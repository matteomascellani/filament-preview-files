<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

use Filament\Tables\Actions\Action;

class MediaUnavailableAction
{
    /**
     * Build a disabled fallback action for records without a valid media URL.
     */
    public static function make(
        ?callable $urlResolver = null,
        string $name = 'unavailable',
    ): Action {
        $getUrl = $urlResolver ?? fn ($record) => method_exists($record, 'getUrl') ? $record->getUrl() : null;

        return Action::make($name)
            ->label('Non disponibile')
            ->icon('heroicon-o-no-symbol')
            ->color('danger')
            ->iconButton()
            ->tooltip('Anteprima non disponibile')
            ->disabled()
            ->visible(fn ($record) => !filled($getUrl($record)));
    }
}
