<?php

namespace App\Support\Helpers;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;

class FileHelper
{
    /**
     * Upload a file to the specified path using a provided name.
     * This method ensures the filename is unique by appending a counter if necessary
     * and returns the final unique filename.
     *
     * @param UploadedFile $file The file from the request.
     * @param string $path The path to upload the file to.
     * @param string $name The desired filename (without extension).
     * @return string The unique filename of the uploaded file.
     */
    public static function uploadFile(UploadedFile $file, string $path, string $name): string
    {
        // Ensure the directory exists or create it.
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Get the file extension.
        $extension = $file->getClientOriginalExtension();

        // Combine the provided name with the extension.
        $customFilename = $name . '.' . $extension;

        // Sanitize a filename by removing unexpected symbols and characters.
        $sanitizedFilename = self::sanitizeFilename($customFilename);

        // Ensure the filename is unique in the given path.
        $filename = self::ensureUniqueFilename($sanitizedFilename, $path);

        // Move the file to the destination path.
        $file->move($path, $filename);

        return $filename;
    }

    /**
     * Resize an image using the intervention/image-laravel package.
     *
     * @param string $path The path to the image file.
     * @param int|null $width The desired width of the resized image (optional).
     * @param int|null $height The desired height of the resized image (optional).
     * @return void
     */
    public static function resizeImage(string $path, ?int $width = null, ?int $height = null): void
    {
        // Load the image
        $image = Image::read($path);

        // Perform resizing based on provided width and height
        if ($width && $height) {
            // Resize and crop the image to fit the exact width and height
            // Fitted Image Resizing | Cropping & Resizing Combined
            $image->cover($width, $height);
        } else {
            // Resize while maintaining aspect ratio
            // Resizing Images Proportionally
            $image->scale($width, $height);
        }

        // Save the resized image to the same path
        $image->save($path);
    }

    /**
     * Sanitize a filename by removing unexpected symbols and characters.
     *
     * @param string $filename The original filename.
     * @return string The sanitized filename.
     */
    public static function sanitizeFilename(string $filename): string
    {
        // Allow only alphanumeric characters, dashes, underscores, dots, and spaces
        $sanitized = preg_replace('/[^a-zA-Z0-9\-\_\.\s]/', '', $filename);

        // Trim any unnecessary spaces from the beginning and end of the filename
        return trim($sanitized);
    }

    /**
     * Ensure the filename is unique by appending a counter if the file already exists.
     * Renaming style: name(i++).ext, where i is an incrementing counter.
     *
     * @param string $filename The original filename.
     * @param string $path The path where the file is located.
     * @return string The new filename with a unique name to avoid duplication.
     */
    public static function ensureUniqueFilename(string $filename, string $path): string
    {
        // Extract the file extension and the base filename.
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $name = pathinfo($filename, PATHINFO_FILENAME);

        // Ensure the path ends with a slash for consistency.
        $path = rtrim($path, '/') . '/';

        // Initialize the counter to append to the filename in case of duplication.
        $counter = 1;

        // Iterate until a unique filename is found.
        while (file_exists($path . $filename)) {
            // Append the counter to the base filename and update the full filename.
            $filename = sprintf('%s(%d).%s', $name, $counter++, $extension);
        }

        return $filename;
    }
}
