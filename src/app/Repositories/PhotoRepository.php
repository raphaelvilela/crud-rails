<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 08/02/2018
 * Time: 22:10
 */

namespace RaphaelVilela\CrudRails\App\Repositories;

use App\Photo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class PhotoRepository
{
    public static $THUMB_IMAGE_QUALITY = 80;
    public static $MINI_IMAGE_QUALITY = 80;

    /**
     * Realizado o download no arquivo da URL e retorna o path do arquivo local.
     * @param string $url
     * @return string
     */
    private static function downloadFileFromUrl(string $url): string
    {
        $file_name = str_random(16);
        $file_path = storage_path() . "/" . $file_name;

        $client = new Client();
        $client->request('GET', $url, ['sink' => $file_path]);

        Log::info("Arquivo " . $url . " salvo em disco local: " . $file_path);
        return $file_path;
    }

    public static function createPhotoFromUrl(string $full_photo_url, string $path): Photo
    {
        $local_file_path = self::downloadFileFromUrl($full_photo_url);
        return self::createPhotoFromLocalFile($local_file_path, $path);
    }

    public static function createPhotoFromLocalFile($local_file_path, string $path): Photo
    {
        $photo = new Photo();
        $photo->full_url = "temp-url";
        $photo->thumb_url = "temp-url";
        $photo->mini_url = "temp-url";
        $photo->save();

        if (!is_dir(storage_path() . $path)) {
            mkdir(storage_path() . $path);
        }

        $path = $path . "/" . $photo->id;
        if (!is_dir(storage_path() . $path)) {
            mkdir(storage_path() . $path);
        }

        $manager = new ImageManager(array('driver' => config('image.driver')));

        $fullPhotoFileName = $path . "/" . $photo->id . "-full.jpg";
        Storage::disk(config('crud-rails.photos.filesystem.name'))->put($fullPhotoFileName, file_get_contents($local_file_path));

        $thumbPhotoFileName = $path . "/" . $photo->id . "-200x200.jpg";
        $manager->make($local_file_path)->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path() . $thumbPhotoFileName, self::$THUMB_IMAGE_QUALITY);
        Storage::disk(config('crud-rails.photos.filesystem.name'))->put($thumbPhotoFileName, file_get_contents(storage_path() . $thumbPhotoFileName));

        $miniPhotoFileName = $path . "/" . $photo->id . "-100x100.jpg";
        $manager->make($local_file_path)->fit(100, 100, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path() . ($miniPhotoFileName), self::$MINI_IMAGE_QUALITY);
        Storage::disk(config('crud-rails.photos.filesystem.name'))->put(
            $miniPhotoFileName,
            file_get_contents(storage_path() . ($miniPhotoFileName))
        );

        $photo->full_url = config('crud-rails.photos.filesystem.base-url') . $fullPhotoFileName;
        $photo->thumb_url = config('crud-rails.photos.filesystem.base-url') . $thumbPhotoFileName;
        $photo->mini_url = config('crud-rails.photos.filesystem.base-url') . $miniPhotoFileName;
        $photo->save();

        try {
            //Apaga o arquivo local
            unlink($local_file_path);
            unlink(storage_path() . ($thumbPhotoFileName));
            unlink(storage_path() . ($miniPhotoFileName));
        } catch (\Exception $ex) {

        }

        return $photo;
    }
}