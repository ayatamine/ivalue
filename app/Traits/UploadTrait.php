<?php

namespace App\Traits;

use App\Models\File;

Trait UploadTrait
{
    /************ upload main image ******************/
    function saveimage($image , $folder , $imageable_id , $imageable_type , $type)
    {
        $albumImage = new File();
        $fileimagename = time() . '-' . $image->getClientOriginalName();
        $path = $folder;
        $image->move($path , $fileimagename);
        $albumImage->fileable_id = $imageable_id;
        $albumImage->fileable_type = $imageable_type;
        $albumImage->type = $type;
        $albumImage->file = $fileimagename;
        $albumImage->save();
    }
    /************ edit main image ******************/
    function editimage($image , $folder , $imageable_id , $imageable_type , $type)
    {
        $imagee = File::where('fileable_type' , $imageable_type)->where('type', $type)->where('fileable_id' , $imageable_id)->first();
        if(isset($imagee)){
            @unlink($folder.'/'. $imagee->file);
            $imagee->delete();
        }
        $albumImage = new File();
        $fileimagename = time() . '-' . $image->getClientOriginalName();
        $path = $folder;
        $image->move($path , $fileimagename);
        $albumImage->fileable_id = $imageable_id;
        $albumImage->fileable_type = $imageable_type;
        $albumImage->type = $type;
        $albumImage->file = $fileimagename;
        $albumImage->save();
    }
    /******* upload multi images *************/
    function saveimages($images , $folder , $imageable_id , $imageable_type , $type)
    {
        foreach ($images as $image){
            $albumImage = new File();
            $filename = time() . '--' . $image->getClientOriginalName();
            $path = $folder;
            $image->move($path , $filename);
            $albumImage->fileable_id = $imageable_id;
            $albumImage->fileable_type = $imageable_type;
            $albumImage->type = $type;
            $albumImage->file = $filename;
            $albumImage->save();
        }
    }
    /**************** delete and unlink images ************/
    function deleteimages($id , $path , $imageable_type)
    {
        $images = File::where('fileable_id' , $id)->where('fileable_type' , $imageable_type)->get();
        foreach($images as $image){
            @unlink($path . $image->file);
            $image->delete();
        }
    }
}
