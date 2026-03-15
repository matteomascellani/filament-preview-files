# filament-preview-files

Reusable Filament v4 actions and Blade views for:

- media zoom preview (images and PDF)
- media open in new tab
- graceful fallback when URL is missing (red unavailable icon)

## Requirements

- Filament `^4.0`
- Spatie Media Library `^11.0`
- Laravel `^11.28|^12.0`
- PHP `^8.2`

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
use Matteomascellani\FilamentPreviewFiles\Actions\MediaPreviewAction;
use Matteomascellani\FilamentPreviewFiles\Actions\MediaOpenAction;
use Matteomascellani\FilamentPreviewFiles\Actions\MediaZoomAction;
use Matteomascellani\FilamentPreviewFiles\Actions\MediaUnavailableAction;
```

```php
->actions([
  // Wrapper that injects all table actions:
  // - zoom (only for image/pdf with valid URL)
  // - open in new tab (only with valid URL)
  // - unavailable fallback (red no-symbol when URL is missing)
  ...MediaPreviewAction::make(
    urlResolver: fn ($record) => $record->getUrl(),
    mimeResolver: fn ($record) => (string) $record->mime_type,
  ),
])
```

If you prefer separate actions, all single actions are still available:

```php
->actions([
  MediaZoomAction::make(
    urlResolver: fn ($record) => $record->getUrl(),
    mimeResolver: fn ($record) => (string) $record->mime_type,
  ),

  MediaOpenAction::make(
    urlResolver: fn ($record) => $record->getUrl(),
  ),

  MediaUnavailableAction::make(
    urlResolver: fn ($record) => $record->getUrl(),
  ),
])
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
- `...MediaPreviewAction::make(...)` in table actions

## Branching And Versioning

- `1.x`: Filament 3 compatible line (Laravel 11)
- `2.x`: Filament 4 compatible line

Suggested release policy:

- publish `v1.*` tags from `1.x`
- publish `v2.*` tags from `2.x`
