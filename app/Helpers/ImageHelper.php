<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Upload image with resize and aspect ratio maintained
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder (relative to public/)
     * @param int $width
     * @param int $quality
     * @return string|null
     */
    public static function upload($file, $folder = 'uploads/images', $width = 800, $quality = 90)
    {
        // Ensure folder exists
        $uploadPath = public_path($folder);
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = time() . '-' . Str::slug($originalName) . '.' . $extension;
        $destination = $uploadPath . '/' . $fileName;

        // Resize manually using GD
        list($origWidth, $origHeight) = getimagesize($file);
        $ratio = $origHeight / $origWidth;
        $newWidth = $width;
        $newHeight = $width * $ratio;

        $mime = $file->getMimeType();

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = imagecreatefromjpeg($file);
                break;
            case 'image/png':
                $src = imagecreatefrompng($file);
                break;
            case 'image/gif':
                $src = imagecreatefromgif($file);
                break;
            default:
                return null; // unsupported type
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG/GIF
        if ($mime == 'image/png' || $mime == 'image/gif') {
            imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save image
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($dst, $destination, $quality);
                break;
            case 'image/png':
                imagepng($dst, $destination);
                break;
            case 'image/gif':
                imagegif($dst, $destination);
                break;
        }

        // Free memory
        imagedestroy($src);
        imagedestroy($dst);

        return $folder . '/' . $fileName;
    }

    /**
     * Delete existing image from public folder
     *
     * @param string $path
     * @return bool
     */
    public static function delete($path)
    {
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            return File::delete($fullPath);
        }
        return false;
    }
}
