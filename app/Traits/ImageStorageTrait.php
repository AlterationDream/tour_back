<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageStorageTrait {
    static string $disk = 'public';

    /**
     * Stores an image in the storage and returns its path.
     * @param UploadedFile $image - Image file from $request->file()
     * @param string $folder - Name of a folder in the storage with no slashes (eg. folder-name)
     * @return string - A path to the image
     */
    public function storeImage($image, $folder): string
    {
        $imgName = date('Y-m-d_h-i-s') . "_" . self::generateRandomString() . '.' . $image->getClientOriginalExtension();
        return '/storage/' . $image->storeAs($folder, $imgName, self::$disk);
    }

    public function storeB64Image($imageString, $folder): string
    {
        $image = Image::make(file_get_contents($imageString));
        $imgName = date('Y-m-d_h-i-s') . "_" . self::generateRandomString() . $this->getB64Extension($image);
        Storage::disk(self::$disk)->put($folder.'/'.$imgName, $image);
        return '/storage/'.$folder.'/'.$imgName;
    }

    private function getB64Extension($image): string
    {
        $mime = $image->mime();  //edited due to updated to 2.x
        if ($mime == 'image/jpeg')
            return '.jpg';
        elseif ($mime == 'image/png')
            return '.png';
        elseif ($mime == 'image/gif')
            return '.gif';
        else
            return '';
    }

    /**
     * Replaces an old image in the storage with a new one.
     * @param UploadedFile $newImage - Image file from $request->file()
     * @param string $oldImage - Old image dir and name (eg. /storage/folder-name/image-name.png)
     * @param string $folder - Name of a folder in the storage with no slashes (eg. folder-name)
     * @return string - A path to the new image
     */
    public function replaceImage($newImage, $oldImage, $folder): string
    {
        $this->deleteImage($oldImage, $folder);

        $imgName = date('Y-m-d_h-i-s') . "_" . $this->generateRandomString() . '.' . $newImage->getClientOriginalExtension();
        return '/storage/' . $newImage->storeAs($folder, $imgName, self::$disk);
    }

    /**
     * Deletes an image in the storage at a given path.
     * @param $path - Path to the image
     * @param $folder - Name of a folder in the storage with no slashes (eg. folder-name)
     */
    public function deleteImage($path, $folder) {
        $path = explode('/', $path);
        $imgName = end($path);
        if (Storage::disk(self::$disk)->exists($folder.'/'.$imgName)) {
            Storage::disk(self::$disk)->delete($folder.'/' . $imgName);
        }
    }

    /**
     * Generates a random string of preset characters of a given length.
     * @param int $length - String length
     * @return string - Random string
     */
    private function generateRandomString($length = 8): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
