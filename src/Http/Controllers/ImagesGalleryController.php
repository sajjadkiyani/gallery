<?php
namespace Kiyani\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Kiyani\Gallery\Models\Gallery;
use Kiyani\Gallery\Models\ImagesGallery;
use RealRashid\SweetAlert\Facades\Alert;
class ImagesGalleryController extends BaseController
{
    public function index()
    {
        $gallery = Gallery::whereId(3)->first();
        return view('gallery::dashboard.gallery.image-gallery',compact('gallery'));
    }
    public function upload(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'gallery_id' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);
        $link = $this->uploadImage($request->image ,'gallery/'.$request->gallery_id);
        $input['image'] = $link ;
        $input['thumbnail'] = $link;
        $input['title'] = $request->title;
        $input['gallery_id'] = $request->gallery_id;
        ImagesGallery::create($input);
        return back();
//        return back()->response()->json(['notification' => ['type' => 'success' , 'title'=> Lang::get('success') , 'message' => Lang::get('game create successfully.') , 'position' => 'bottomLeft']]);
    }

    public function edit($gallery_id)
    {
        $gallery = Gallery::whereId($gallery_id)->first();
        return view('gallery::dashboard.gallery.images_edit',compact('gallery'));
    }
    public function destroy($id)
    {
        $image = ImagesGallery::find($id);
        unlink(public_path($image->image));
        $image->delete();
        return back()->with(['notification' => ['type' => 'success' , 'title'=> Lang::get('success') , 'message' => Lang::get('image deleted successfully.') , 'position' => 'bottomLeft']]);
    }
}
