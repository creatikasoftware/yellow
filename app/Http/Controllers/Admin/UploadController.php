<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    use HandlesUploads;

    /**
     * Store an image uploaded from a rich text editor and return its public
     * URL, so the editor can insert it inline without a full page submit.
     */
    public function image(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:4096'],
        ]);

        $path = $this->storeUploadedImage($request, 'image', 'editor');

        return response()->json(['url' => Storage::url($path)]);
    }
}
