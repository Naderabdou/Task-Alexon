<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait CategoryTrait
{
    public function deleteImage($photo)
    {
        $path =  $photo;
    $path=  substr($path, strpos($path, "uploads/categories/"));
        if (File::exists($path)){
            File::delete($path);

        }

    }
    public function saveImage($photo, $folder,$category)
    {
        //save photo in folder
        $file_name = $category->getImageNameAttribute(time()) . '.' . $photo->getClientOriginalExtension();
        $path = $folder;
        $photo->move($path, $file_name);
        return $file_name;
    }

    public function extracted(array $data, $category, Request $request): void
    {
        $category->name_ar = $data['name_ar'];
        $category->name_en = $data['name_en'];
        if ($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $category->image = $this->saveImage($request->file('image'), 'uploads/categories/',$category);
        }
        $category->save();
    }

}
