<?php


namespace App\Http\Services\Storage;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Upload file to folder with FileSystems
     *
     * @param string        $diskName
     * @param UploadedFile $uploadedFile
     *
     * @return string $fileUrl;
     */
    public function storeFile ($diskName, $uploadedFile) {

        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = Str::uuid();
        $fileNameWithExtension = "$fileName.$extension";

        Storage::disk($diskName)->put($fileNameWithExtension, File::get($uploadedFile));

        return $fileNameWithExtension;
    }

    /**
     * Get File URL to display for Public
     *
     * @param string  $diskName
     * @param string  $fileUrl
     *
     * @return string $publicFileUrl;
     */
    public function getFilePublicUrl ($diskName, $fileUrl) {

        $publicFileUrl = Storage::disk($diskName)->url($fileUrl);
        return $publicFileUrl;
    }
}
