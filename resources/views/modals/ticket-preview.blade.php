@if (!$ticket)
    <div class="py-6 text-sm text-gray-500 dark:text-gray-400">
        Ticket non disponibile.
    </div>
@else
<div class="space-y-4 py-1">

    <div class="rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 p-4 space-y-3">
        <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs text-gray-500 dark:text-gray-400">
            <span>
                <span class="font-medium text-gray-700 dark:text-gray-300">Cliente:</span>
                {{ $ticket->owner?->full_name ?? '-' }}
                @if ($ticket->owner?->email)
                    <span class="text-gray-400">({{ $ticket->owner->email }})</span>
                @endif
            </span>
            @if ($ticket->tenant?->name)
            <span>
                <span class="font-medium text-gray-700 dark:text-gray-300">Sito:</span>
                {{ $ticket->tenant->name }}
            </span>
            @endif
            <span>
                <span class="font-medium text-gray-700 dark:text-gray-300">Aperto:</span>
                {{ $ticket->created_at?->format('d/m/Y H:i') }}
            </span>
        </div>

        @if ($ticket->content)
        <div class="prose prose-sm dark:prose-invert max-w-none border-t border-gray-200 dark:border-white/10 pt-3">
            {!! \Illuminate\Support\Str::markdown(e($ticket->content)) !!}
        </div>
        @endif

        @php $ticketMedia = method_exists($ticket, 'getMedia') ? $ticket->getMedia('attachments') : collect(); @endphp
        @if ($ticketMedia->isNotEmpty())
        <div class="border-t border-gray-200 dark:border-white/10 pt-2 space-y-1">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Allegati ticket</p>
            <div class="flex flex-wrap gap-2">
                @foreach ($ticketMedia as $m)
                    @if (str_starts_with((string) $m->mime_type, 'image/'))
                        <a href="{{ $m->getUrl() }}" target="_blank" title="{{ $m->file_name }}">
                            <img src="{{ $m->getUrl() }}" class="h-16 w-16 object-cover rounded border border-gray-200 dark:border-white/20" alt="{{ $m->file_name }}">
                        </a>
                    @else
                        <a href="{{ $m->getUrl() }}" target="_blank"
                           class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-primary-600 dark:text-primary-400 hover:underline">
                            Attachment {{ $m->file_name }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @php $comments = $ticket->filamentComments ?? collect(); @endphp
    @if ($comments->isEmpty())
        <p class="text-sm text-gray-400 dark:text-gray-500 italic text-center py-3">Nessun commento</p>
    @else
        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide">
            Commenti ({{ $comments->count() }})
        </p>
        <div class="space-y-3">
            @foreach ($comments as $comment)
            <div class="rounded-xl border border-gray-200 dark:border-white/10 p-3 space-y-2">
                <div class="flex items-center gap-2 flex-wrap text-xs">
                    <span class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ $comment->user?->full_name ?? '-' }}
                    </span>
                    @if ($comment->user?->email)
                        <span class="text-gray-400">{{ $comment->user->email }}</span>
                    @endif
                    <span class="text-gray-400 ml-auto">{{ $comment->created_at?->format('d/m/Y H:i') }}</span>
                    @if ($comment->label)
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300">
                            {{ $comment->label->getLabel() }}
                        </span>
                    @endif
                </div>

                @if ($comment->comment)
                <div class="prose prose-sm dark:prose-invert max-w-none">
                    {!! \Illuminate\Support\Str::markdown(e($comment->comment)) !!}
                </div>
                @endif

                @php $commentMedia = method_exists($comment, 'getMedia') ? $comment->getMedia('attachments') : collect(); @endphp
                @if ($commentMedia->isNotEmpty())
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-100 dark:border-white/5">
                    @foreach ($commentMedia as $m)
                        @if (str_starts_with((string) $m->mime_type, 'image/'))
                            <a href="{{ $m->getUrl() }}" target="_blank" title="{{ $m->file_name }}">
                                <img src="{{ $m->getUrl() }}" class="h-16 w-16 object-cover rounded border border-gray-200 dark:border-white/20" alt="{{ $m->file_name }}">
                            </a>
                        @else
                            <a href="{{ $m->getUrl() }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-primary-600 dark:text-primary-400 hover:underline">
                                Attachment {{ $m->file_name }}
                            </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif

</div>
@endif
