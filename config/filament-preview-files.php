<?php

return [
    'ticket_preview' => [
        'view' => 'filament-preview-files::modals.ticket-preview',
        'default_relations' => [
            'owner',
            'tenant',
            'filamentComments' => fn ($query) => $query->with(['user', 'media'])->orderBy('created_at'),
            'media',
        ],
        'label' => 'Anteprima',
        'cancel_label' => 'Chiudi',
        'modal_width' => '5xl',
    ],
    'media_zoom' => [
        'view' => 'filament-preview-files::modals.media-zoom-content',
        'label' => 'Zoom',
        'modal_width' => '7xl',
    ],
];
