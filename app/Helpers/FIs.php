<?php

use Intervention\Image\ImageManagerStatic as Image;

function resize_upload_image($image, $folder = 'avatars')
{
    $thump = $image;
    $image_name = $folder . '/' . time() . rand(1, 100000) . '.' . $image->getClientOriginalExtension();

    $original = Image::make($image->getRealPath());
    $original = $original->resize(1200);
    $original->save(storage_path('app/public/' . $image_name));

    $thumb = Image::make($image->getRealPath());
    $thumb = $thumb->resize(300, 200);
    $thumb->save(storage_path('app/public/thump/' . $image_name));
    return $image_name;
}
