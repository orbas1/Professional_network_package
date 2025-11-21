<?php

namespace ProNetwork\Services;

use Illuminate\Support\Facades\Storage;
use RuntimeException;

class StorageService
{
    public function disk()
    {
        $disk = config('pro_network_utilities_security_analytics.storage.default_disk', 'local');
        return Storage::disk($disk);
    }

    public function putEncrypted(string $path, string $contents): string
    {
        $encrypted = encrypt($contents);
        $this->disk()->put($path, $encrypted);
        return $path;
    }

    public function signedUrl(string $path): string
    {
        $ttl = (int) config('pro_network_utilities_security_analytics.storage.signed_url_ttl', 300);
        $disk = $this->disk();
        if (method_exists($disk, 'temporaryUrl')) {
            return $disk->temporaryUrl($path, now()->addSeconds($ttl));
        }
        throw new RuntimeException('Disk does not support signed URLs');
    }
}
