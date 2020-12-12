<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $perPage = 12;


    // returns file name for database storage

    protected function storeImage($image)
    {


        if ($image->isValid()) {

            $path = $image->store('images');

            return $path;
        }

        return false;
    }


    protected function editStoreImage($imagePath, $imageFile) {

        if (Storage::exists($imagePath)) {

            Storage::delete($imagePath);
        }

        $path = $this->storeImage($imageFile);

        return $path;

    }


}
