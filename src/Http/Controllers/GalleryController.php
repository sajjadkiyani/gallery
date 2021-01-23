<?php
namespace Kiyani\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use Kiyani\Gallery\Models\Gallery;
use RealRashid\SweetAlert\Facades\Alert;
class GalleryController extends BaseController
{

    public function index()
    {
        $gallery = Gallery::orderBy('id','DESC')->get();
        return view('gallery::dashboard.gallery.all',compact('gallery'));
    }

    public function create()
    {
        return view('gallery::dashboard.gallery.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $gallery = Gallery::create([
            'title' => $request->title ,
            'description' => $request->description ,
            'is_private' => $request->private ,
        ]);
        if ($gallery)
            $links = $this->uploadImage($request->images ,'/gallery/'.$gallery->id.'/');
            if ($links){
                foreach ($links as $link){
                    $gallery->images()->create([
                        'url' => $link
                    ]);
                }
            }
        return redirect()->route('gallery.index') ;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $gallery = Gallery::whereId($id)->first();
        Alert::success('Success Title', 'Success Message');
        return view('gallery::dashboard.gallery.edit',compact('gallery'));
    }

    public function update(Request $request,$id)
    {

        $this->validation($request);
        $gallery = Gallery::find($id);
        $gallery->update([
            'title' => $request->title ,
            'description' => $request->description ,
            'is_private' => $request->private ,
        ]);
            $links = $this->uploadImage($request->images ,'/gallery/'.$gallery->id.'/');
        SweetAlert::message('Robots are working!');
        return redirect(route('gallery.index'));
        if ($links)
            foreach ($links as $link){
            $gallery->images()->create([
                'url' => $link
            ]);
        }
            return response()->json([
                'result' => true,
                'msg' => 'با موفقیت حذف شد'
            ]);
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->delete()){
            return response()->json([
                'result' => true,
                'msg' => 'با موفقیت حذف شد'
            ]);
        }else{
            return response()->json([
                'result' => true,
                'msg' => 'خطا در حذف .دوباره سعی کنید'
            ]);
        }
    }

    public function validation($request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'description' => 'required|min:2',
            'private' => 'required',
        ]);
    }
}
