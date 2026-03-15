<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

class MediaPreviewAction
{
    /**
     * Build both reusable actions (zoom modal + open in new tab) in one call.
     *
     * Usage:
    *   ->recordActions([
     *       ...MediaPreviewAction::make(
     *           urlResolver: fn ($record) => $record->getUrl(),
     *           mimeResolver: fn ($record) => (string) $record->mime_type,
     *       ),
     *   ])
     */
    public static function make(
        ?callable $urlResolver = null,
        ?callable $mimeResolver = null,
        ?callable $headingResolver = null,
        string $zoomName = 'zoom',
        string $openName = 'open',
        string $unavailableName = 'unavailable',
    ): array {
        return [
            MediaZoomAction::make(
                urlResolver: $urlResolver,
                mimeResolver: $mimeResolver,
                headingResolver: $headingResolver,
                name: $zoomName,
            ),
            MediaOpenAction::make(
                urlResolver: $urlResolver,
                name: $openName,
            ),
            MediaUnavailableAction::make(
                urlResolver: $urlResolver,
                name: $unavailableName,
            ),
        ];
    }
}
