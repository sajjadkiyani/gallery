<?php
namespace Kiyani\Gallery\Http\Controllers;

use app\helpers\Converter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Kiyani\Gallery\Models\Gallery;
use Illuminate\Filesystem\Filesystem;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class GalleryController extends BaseController
{

    public function index(Request $request)
    {
        $fields = getDataTableColums('galleries');
       array_splice($fields , '4' , '1' ,'count_image');
        if ($request->ajax()) {
            $data = Gallery::orderBy('id','DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at' ,function ($row){
                    $created_at = '';
                    if ($row->created_at){
                        $created_at = Converter::toEnglish(jDateTime('Y-m-d',strtotime($row->created_at) ));
                    }
                    return  $created_at;
                })
                ->addColumn('user_id' ,function ($row){
                    return User::whereId(1)->first() ? User::whereId(1)->first()->name : '' ;
                })
                ->addColumn('count_image' ,function ($row){
                   return '<a href="'.route('image-gallery.edit',['image_gallery' => $row->id]).'" >'.count($row->images).'</a>';
                })
                ->addColumn('status' ,function ($row){
                    return $row->status() ;
                })
                ->addColumn('is_private' ,function ($row){
                    return $row->is_private() ;
                })
                ->addColumn('published_at' ,function ($row){
                    $publish_at = '';
                    if ($row->published_at){
                        $publish_at = Converter::toEnglish(jDateTime('Y-m-d',strtotime($row->published_at) ));
                    }
                    return  $publish_at;
                })
                ->addColumn('updated_at' ,function ($row){
                    $created_at = '';
                    if ($row->created_at){
                        $created_at = Converter::toEnglish(jDateTime('Y-m-d',strtotime($row->updated_at) ));
                    }
                    return  $created_at;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('gallery.edit',['gallery' => $row->id]).'"  class="edit   editticket" >'.globalIcons('edit').'</a>';
                    $btn = $btn . '<a href="'.route('gallery.show',['gallery' => $row->id]).'">'.globalIcons('eye').'</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class=" deleteGallery">'.globalIcons('trash').'</a>';
                    return $btn;
                })
                ->rawColumns(['action' ,'count_image'])
                ->make(true);
        }
        $page_name = 'gallery';
        $category_name = 'gallery';
        return view('gallery::dashboard.gallery.all',compact('page_name' , 'category_name' ,'fields'));
    }

    public function create()
    {
        return view('gallery::dashboard.gallery.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $gallery = Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_private' => $request->private,
            'published_at' => $request->publish? Carbon::now() :null,
        ]);
        if ($gallery)
            $link = $this->uploadImage($request->image, 'gallery/' . $gallery->id);
        if ($link) {
            $image = $gallery->images()->create([
                'thumbnail' => $link,
                'image' => $link
            ]);
        }
            $gallery->update([
               'title_image' => $image->id
            ]);
        return redirect()->route('gallery.index') ;
    }

    public function show(Gallery $gallery)
    {
        return view('gallery::dashboard.gallery.show' ,compact('gallery'));
    }

    public function edit($id)
    {
        $page_name = 'edit gallery';
        $gallery = Gallery::whereId($id)->first();
        return view('gallery::dashboard.gallery.edit',compact('gallery' ,'page_name'));
    }

    public function update(Request $request,$id)
    {

        $this->validation($request);
        $gallery = Gallery::find($id);
        $gallery->update([
            'title' => $request->title ,
            'description' => $request->description ,
            'is_private' => $request->private ,
            'published_at' => $request->publish? Carbon::now() :null,
        ]);
        $link = null;
        if ($request->image)
            $link = $this->uploadImage($request->image, 'gallery/' . $gallery->id);
        if ($link) {
            $image = $gallery->images()->create([
                'thumbnail' => $link,
                'image' => $link
            ]);
            $gallery->update([
                'title_image' => $image->id
            ]);
        }
//        Alert::success('موفق', 'گالری با موفقیت ویرایش شد');
        return redirect(route('gallery.index'));
    }

    public function destroy($id)
    {
        $gallery = Gallery::whereId($id)->first();
        $this->deleteImages($gallery);
        $gallery->delete();
        return response()->json(['notification' => ['type' => 'success' , 'title'=> Lang::get('success') , 'message' => Lang::get('gallery deleted successfully.') , 'position' => 'bottomLeft']]);
    }

    public function validation($request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'description' => 'required|min:2',
            'private' => 'required',
            'publish' => 'required',
        ]);
    }

    public function deleteImages($gallery){
       $images = $gallery->images;
       if (count($images)){
           \File::deleteDirectory(public_path('gallery/'.$gallery->id));
       }
    }
}
