<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{

    public function save($file, $output)
    {
        $disk = Storage::disk('local');

        $image = Image::make($file);

        $output_all = $output == 'all';
        if ($output == 'original' || $output_all) {
            $new_file_name = random_int(11111111, 99999999);
            $disk->put("/images/original/$new_file_name.png", (string)$image->encode());
        }

        if ($output == 'square' || $output_all) {
            $this->toSquare($disk, $image);
        }

        if ($output == 'small' || $output_all) {
            $this->toSmall($disk, $image);
        }
    }

    private function toSquare($disk, $image)
    {
        $height = $image->height();
        $width = $image->width();

        if ($height > $width) {
            $image = $image->resize($height, $height, function ($constraint) {
                $constraint->upsize();
            });
        } elseif ($width > $height) {
            $image = $image->resize($height, $height, function ($constraint) {
                $constraint->upsize();
            });
        }
        $new_file_name = random_int(11111111, 99999999);
        $disk->put("/images/square/$new_file_name.png", (string)$image->encode());
    }

    private function toSmall($disk, $image)
    {
        $image = $image->resize(256, 256, function ($constraint) {
            $constraint->upsize();
        });

        $new_file_name = random_int(11111111, 99999999);
        $disk->put("/images/small/$new_file_name.png", (string)$image->encode());
    }

}
