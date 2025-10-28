<?php

namespace App\Traits;

trait HandlesMediaUrls
{
    /**
     * Get the appropriate URL for media (image or video)
     *
     * @param string|null $filename - Just the filename like "video.mp4"
     * @param string $folder - The folder name like "lot", "cemeteries", "messages"
     */
    protected function getMediaUrl($filename, $folder)
    {
        if (!$filename) {
            return null;
        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'flv', 'webm', 'mkv', 'm4v'];

        if (in_array($extension, $videoExtensions)) {
            return url("/videos/{$filename}");
        }

        return asset("storage/{$filename}");
    }

    /**
     * Get media data with type information
     */
    protected function getMediaData($filename, $folder)
    {
        if (!$filename) {
            return null;
        }

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'flv', 'webm', 'mkv', 'm4v'];
        $isVideo = in_array($extension, $videoExtensions);

        return [
            'url' => $isVideo
                ? url("/videos/{$folder}/{$filename}")
                : asset("storage/{$folder}/{$filename}"),
            'type' => $isVideo ? 'video' : 'image',
            'filename' => $filename,
            'folder' => $folder,
        ];
    }
}
