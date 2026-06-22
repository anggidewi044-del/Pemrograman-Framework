<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaStorage
{
    public function store(UploadedFile $file, string $folder): string
    {
        if (!$this->isCloudinaryConfigured()) {
            return $file->store($folder, 'public');
        }

        $result = $this->cloudinary()->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'eventrize/' . trim($folder, '/'),
                'resource_type' => 'image',
            ],
        );

        return (string) $result['secure_url'];
    }

    public function delete(?string $location): void
    {
        if (!$location) {
            return;
        }

        if ($this->isCloudinaryUrl($location)) {
            if ($this->isCloudinaryConfigured() && ($publicId = $this->publicIdFromUrl($location))) {
                $this->cloudinary()->uploadApi()->destroy($publicId, [
                    'resource_type' => 'image',
                    'invalidate' => true,
                ]);
            }

            return;
        }

        Storage::disk('public')->delete($location);
    }

    public function url(?string $location): ?string
    {
        if (!$location) {
            return null;
        }

        return filter_var($location, FILTER_VALIDATE_URL)
            ? $location
            : asset('storage/' . ltrim($location, '/'));
    }

    private function isCloudinaryConfigured(): bool
    {
        return filled(config('cloudinary.cloud_name'))
            && filled(config('cloudinary.api_key'))
            && filled(config('cloudinary.api_secret'));
    }

    private function isCloudinaryUrl(string $location): bool
    {
        return str_contains($location, 'res.cloudinary.com/');
    }

    private function publicIdFromUrl(string $url): ?string
    {
        $path = rawurldecode((string) parse_url($url, PHP_URL_PATH));
        if (!preg_match('~/upload/(?:v\d+/)?(.+?)(?:\.[^./]+)?$~', $path, $matches)) {
            return null;
        }

        return $matches[1];
    }

    private function cloudinary(): Cloudinary
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);
    }
}
