<?php

namespace Matteomascellani\FilamentPreviewFiles\Actions;

use Closure;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketPreviewAction
{
    /**
     * Load default relations used by the modal. Accepts any Eloquent model.
     */
    public static function loadWithRelations(Model $ticket, ?array $relations = null): Model
    {
        $relationsToLoad = $relations ?? config('filament-preview-files.ticket_preview.default_relations', []);
        $ticket->loadMissing($relationsToLoad);

        return $ticket;
    }

    /**
     * Generic action: resolve your ticket-like record from any table row.
     */
    public static function make(Closure $ticketResolver, string $name = 'preview'): Action
    {
        $label = (string) config('filament-preview-files.ticket_preview.label', 'Anteprima');
        $cancelLabel = (string) config('filament-preview-files.ticket_preview.cancel_label', 'Chiudi');
        $width = (string) config('filament-preview-files.ticket_preview.modal_width', '5xl');
        $view = (string) config('filament-preview-files.ticket_preview.view', 'filament-preview-files::modals.ticket-preview');

        return Action::make($name)
            ->label($label)
            ->icon('heroicon-o-eye')
            ->modalHeading(function ($record) use ($ticketResolver, $label) {
                $ticket = $ticketResolver($record);

                if (!$ticket) {
                    return $label;
                }

                $id = data_get($ticket, 'id');
                $title = Str::limit((string) data_get($ticket, 'title', ''), 60);

                if (!$id) {
                    return $label;
                }

                return 'Ticket #' . $id . ' - ' . $title;
            })
            ->modalContent(function ($record) use ($ticketResolver, $view) {
                $ticket = $ticketResolver($record);

                return view($view, [
                    'ticket' => $ticket instanceof Model ? static::loadWithRelations($ticket) : $ticket,
                ]);
            })
            ->modalWidth($width)
            ->modalSubmitAction(false)
            ->modalCancelActionLabel($cancelLabel)
            ->visible(fn ($record) => $ticketResolver($record) !== null);
    }

    /**
     * Shortcut for tables where the record itself is the ticket model.
     */
    public static function forTicket(string $name = 'preview'): Action
    {
        return static::make(fn ($record) => $record, $name);
    }
}
