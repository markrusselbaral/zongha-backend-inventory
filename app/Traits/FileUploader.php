<?php
namespace App\Traits;
use Storage;

trait FileUploader
{
    public function uploadFile($request, $fieldName, $storagePath)
    {
        if ($request->hasFile($fieldName)) {
            $image = $request->file($fieldName);
            $fileName = time() . '_' . $image->getClientOriginalName();
            Storage::putFileAs($storagePath, $image, $fileName);
            return $fileName;
        }
        return null;
    }

    // $fileName = $this->uploadFile($request, 'image', 'public/DC');
}