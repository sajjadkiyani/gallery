<?php
namespace Kiyani\Gallery\ClassCustom\UploadImages;

use App\Http\Controllers\Controller;

class UploadImages extends Controller
{
    public function uploadImage($images,$directory ,$oldUrl = null)
    {
        if (!empty($images) && !empty($directory)){
                if (is_array($images)) {
                    $links = [];
                    foreach ($images as $image){
                        $prefix = $image->getClientOriginalExtension();
                        $fileName = uniqid() .'.'.$prefix ;
                        $image->move(public_path().'/'.$directory, $fileName);
                        $link = '/'.$directory.'/'.$fileName ;
                        array_push($links,$link);
                    }
                    return $links ;
                }else {
                    $prefix = $images->getClientOriginalExtension();
                    $fileName = uniqid() .'.'.$prefix ;
                    $images->move(public_path().'/'.$directory, $fileName);
                    $link = '/'.$directory.'/'.$fileName ;
                    return  $link ;
                }
        }else{
            return $oldUrl ;
        }
    }
}
