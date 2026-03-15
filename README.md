# filament-preview-files

Reusable Filament v3 actions and Blade views for:

- media zoom preview (images and PDF)
- ticket preview modal with comments and attachments

## Install

### From Packagist (recommended)

```bash
composer require matteomascellani/filament-preview-files
```

### From local path (development)

Add to root `composer.json`:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "packages/matteomascellani/filament-preview-files"
    }
  ]
}
```

Then require the package:

```bash
composer require matteomascellani/filament-preview-files:*
```

## Service Provider

The package uses Laravel auto-discovery via `extra.laravel.providers`, so in normal setups you do not need to register the provider manually.

If your project disables package discovery, register manually:

```php
Matteomascellani\FilamentPreviewFiles\FilamentPreviewFilesServiceProvider::class,
```

Optional: publish config.

```bash
php artisan vendor:publish --tag=filament-preview-files-config
```

## Usage

### 1) Use in a Filament table (Actions)

```php
use Matteomascellani\FilamentPreviewFiles\Actions\MediaZoomAction;
use Matteomascellani\FilamentPreviewFiles\Actions\TicketPreviewAction;
```

```php
->actions([
  MediaZoomAction::make(
    urlResolver: fn ($record) => $record->getUrl(),
    mimeResolver: fn ($record) => (string) $record->mime_type,
  ),

  TicketPreviewAction::make(
    ticketResolver: fn ($record) => $record->ticket,
  ),
])
```

If your table record is already the ticket model:

```php
TicketPreviewAction::forTicket()
```

### 2) Use in a normal Blade view

You can include the package views directly, even outside Filament table actions.

Media zoom modal content:

```blade
@include('filament-preview-files::modals.media-zoom-content', [
  'url' => $url,
  'mimeType' => $mimeType,
  'label' => $label,
])
```

Ticket preview modal content:

```blade
@include('filament-preview-files::modals.ticket-preview', [
  'ticket' => $ticket,
])
```

Helper component-like partial for link + zoom trigger:

```blade
@include('filament-preview-files::components.media-zoom-link', [
  'url' => $url,
  'mimeType' => $mimeType,
  'label' => $label,
])
```

## Current Usage In This Project

- `app/Filament/Resources/System/MediaResource.php`
- `MediaZoomAction::make(...)` in table actions
- `TicketPreviewAction::make(...)` in table actions
- `TicketPreviewAction::loadWithRelations(...)` helper use
