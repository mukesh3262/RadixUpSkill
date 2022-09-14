<?php
namespace App\Traits;

trait Imageable
{
    public function storeMedia($request)
    {
        $path = public_path('uploads');
        
        if ( ! file_exists($path) ) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('image');

        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());
        
        // $this->image = $fileName;
        // $this->save();
        
        $file->move($path, $fileName);

        return $fileName;
    }
}