<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 9/05/19
 * Time: 4:44 PM
 */

namespace App\Helpers\General;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileHelper
{
    const PATH_IMG = 'img/general';
    const PATH_AVATAR = 'img/avatar';

    /**
     * Store an array of UploadedFile instance to the storage disk
     * @param array $files
     * @param string $filePath
     * @return array|null
     */
    public static function storeFiles(array $files, string $filePath = self::PATH_IMG, $options = [])
    {
        return array_map(function ($file) use ($filePath, $options) {
            $file = \Illuminate\Http\UploadedFile::createFromBase($file); // to resolve path request workaround which return symfony uploadedFile instance
            $path = Storage::putFile('public/' . $filePath, $file, $options);

            return $path;
        }, $files);
    }

    /**
     * Shrink image size and return an array of images urls stored in storage
     * @param array $images
     * @param string $imagePath path to store the image relative to the public/img dir
     * @return array
     */
    public static function imageProcessor(array $images, string $imagePath = self::PATH_IMG, $options = []): array
    {
        $imagesPathArray = self::storeFiles($images, $imagePath);

        // resize the image to a width of 600 and constrain aspect ratio (auto height)
        $imagesUrlArray = [];
        foreach ($imagesPathArray as $imagePath) {
            $img = Image::make(Storage::get($imagePath));
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $stored = Storage::put($imagePath, $img->encode());
//            Storage::setVisibility($imagePath, $options);
//            array_push($imagesUrlArray, Storage::url($path));
            array_push($imagesUrlArray, $imagePath);
        }

        return $imagesUrlArray;
    }
}
