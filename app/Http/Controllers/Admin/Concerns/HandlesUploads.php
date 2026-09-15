<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    /**
     * Store an uploaded image on the public disk, returning its relative
     * path (suitable for saving on the model), or null if no file was
     * uploaded for this field.
     */
    protected function storeUploadedImage(Request $request, string $field, string $directory): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $request->file($field)->store($directory, 'public');
    }

    /**
     * Delete a previously stored image from the public disk, if present.
     */
    protected function deleteStoredImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
