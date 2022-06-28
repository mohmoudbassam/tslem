<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

function resize_upload_image($image, $folder = 'avatars')
{
    $thump = $image;
    $image_name = $folder . '/' . time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();

    $original = Image::make($image->getRealPath());
    $original = $original->resize(1200, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $original->save(storage_path('app/public/' . $image_name));

    $thumb = Image::make($image->getRealPath());
    $thumb = $thumb->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
    });
    $thumb->save(storage_path('app/public/thump/' . $image_name));
    return $image_name;
}


function resize_old_images($name)
{
    // $files = File::allFiles(storage_path('app/public/avatars'));
    // foreach ($files as $key => $image) {
    //     $ext = explode('.', $image);
    //     $ext = end($ext);
    //     if (in_array($ext, ['png', 'jpg'])) {
            // $original = Image::make(storage_path('app/public/avatars/'.$name));
            // // $name = explode('/', $image);
            // // $name = end($name);
            // $original = $original->resize(1200, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $original->save(storage_path('app/public/avatars/' . $name));

            $thumb = Image::make(storage_path('app/public/or_avatars/'.$name));
            $thumb = $thumb->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumb->save(storage_path('app/public/thump/' . $name));
        // }
    // }
}
