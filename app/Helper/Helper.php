<?php
use Illuminate\Support\Facades\Storage;


function storeFile($folder,$file,$prefix){
  //thumbnail Image

  $fileName = $prefix.'_'.$file->hashName();

  Storage::disk(config('constant.storage_type'))->putFileAs($folder,$file,$fileName);
  return $fileName;
}
