@php
    /** @var mixed $media */
    $media = $media ?? null;

    $name = (string) data_get($media, 'name', data_get($media, 'file_name', 'file'));
    $fileName = (string) data_get($media, 'file_name', '');
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    $label = $name;
    if ($extension !== '') {
        $suffix = '.' . $extension;
        $hasSuffix = str_ends_with(strtolower($label), strtolower($suffix));
        if (! $hasSuffix) {
            $label .= $suffix;
        }
    }
@endphp

<tr class="align-middle">
    <td class="px-3 py-2 text-gray-800 dark:text-gray-100">
        <span class="block truncate" title="{{ $label }}">{{ $label }}</span>
    </td>
    <td class="px-3 py-2 w-1 whitespace-nowrap">
        @include('filament-preview-files::components.media-zoom-link', [
            'url' => method_exists($media, 'getUrl') ? $media->getUrl() : null,
            'mimeType' => (string) data_get($media, 'mime_type', ''),
            'label' => $label,
            'showLabelText' => false,
            'showLabelLink' => false,
        ])
    </td>
</tr>
