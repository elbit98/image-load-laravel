<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Services\ImageService;

class ImageController extends Controller
{
    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function save(ImageRequest $request)
    {
        $this->imageService->save($request->image, $request->output);

        return 'ok';
    }

}
