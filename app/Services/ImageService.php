<?php

/**
 * @uses General Functions
 * @author Ranjitsinh Bhalgariya <ranjit.bhalgariya@txtech.co>
 * @return
 */

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{

    /**
     * @author Khushbu Lakhataria <khushbu.lakhataria@txtech.co>
     *
     * @uses Generate for generate randon string
     *
     * @return string
     */
    public function handleFileUpload(string $folder, object|string $file, string|null $oldfile = "", string $publicFolder = "local"): string
    {
        $newFileName = "";
        // create folder if not exists
        if (!Storage::disk($publicFolder)->exists($folder)) {
            Storage::makeDirectory($publicFolder . "/" . $folder, 0775, true);
        }

        if (!empty($file)) {
            /* $name = $file->getClientOriginalName(); // get files original name
    
            $extension = $file->getClientOriginalExtension(); // get files extension
    
            $newFileName = $file->hashName(); // Generate a unique, random name...
    
            $newExtension = $file->extension(); // Determine the file's extension based on the file's MIME */

            $newFileName = $file->hashName(); // Generate a unique, random name...

            $path = $file->storeAs(
                $folder,
                $newFileName,
                $publicFolder
            );
        }

        if ($oldfile != '') {
            $this->removeFile($folder, $oldfile, $publicFolder);
        }

        return $newFileName;
    }

    public function getFileUrl(string $folder, string|null $fileName = "", string $publicFolder = "local"): string
    {
        //$fileUrl = asset('/images/avatar5.png');
        $fileUrl = "";
        if ($fileName != '') {
            $filePath = $folder . "/" . $fileName;
            if (Storage::disk($publicFolder)->exists($filePath)) {
                $publicFilePath = '/storage/' . $filePath;
                $fileUrl = asset($publicFilePath);
            }
        }
        return $fileUrl;
    }

    public function removeFile(string $folder, string|null $fileName = "", string $publicFolder = "local"): bool
    {
        $filePath = $folder . "/" . $fileName;
        if (Storage::disk($publicFolder)->exists($filePath)) {
            Storage::delete($publicFolder . "/" . $filePath);
        }
        return true;
    }
}
