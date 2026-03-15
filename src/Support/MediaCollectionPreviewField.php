<?php

namespace Matteomascellani\FilamentPreviewFiles\Support;

use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaCollectionPreviewField
{
    public static function make(string $name, string $collection, ?string $label = null): ViewField
    {
        $resolvedLabel = $label ?? Str::headline($collection);

        return ViewField::make($name)
            ->label($resolvedLabel)
            ->view('filament-preview-files::components.media-zoom-link')
            ->viewData(fn (?Model $record): array => [
                'record' => $record,
                'collection' => $collection,
                'heading' => $resolvedLabel,
            ])
            ->columnSpanFull();
    }
}
