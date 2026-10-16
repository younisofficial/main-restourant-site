<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Saves uploaded images directly inside /public/uploads/... so they work
 * on XAMPP / shared hosting without running "php artisan storage:link".
 */
trait HandlesImageUpload
{
    protected function uploadImage(UploadedFile $file, string $folder, ?string $oldPath = null): string
    {
        $dir = public_path("uploads/{$folder}");
        File::ensureDirectoryExists($dir);

        $name = Str::random(12) . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        $this->deleteImage($oldPath);

        return "uploads/{$folder}/{$name}";
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/') && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
