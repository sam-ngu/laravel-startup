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
        return array_map(function ($file)use($filePath, $options){
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
//        $imagesUrlArray = array_map(function ($image)use($imagePath){
//            /* @var $image */
//            $image = \Illuminate\Http\UploadedFile::createFromBase($image); // to resolve path request workaround which return symfony uploadedFile instance
//            $path = Storage::putFile('public/img/' . $imagePath, $image);
//            return Storage::url($path);
//        }, $images);

        // resize the image to a width of 600 and constrain aspect ratio (auto height)
        $imagesUrlArray = [];
        foreach ($imagesPathArray as $imagePath)
        {
            $img = Image::make(Storage::get($imagePath));
//            $img = Image::make($path);
            $img->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
//            $img->save();
            $stored = Storage::disk('s3')->put($imagePath, $img->encode());
            Storage::disk('s3')->setVisibility($imagePath, $options);
            $imagePath = env('AWS_URL') . $imagePath;
//            array_push($imagesUrlArray, Storage::url($path));
            array_push($imagesUrlArray, $imagePath);
        }
        return $imagesUrlArray;
    }
}
