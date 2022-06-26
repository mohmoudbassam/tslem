<?php

namespace App\Http\Controllers\CP\Media;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Media;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('CP.media.index');
    }

    public function list()
    {
        $media = Media::query();

        return DataTables::of($media)
            ->addColumn('actions', function ($media) {

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="javascript:;" onclick="showModal(\'' . route('media.form', ['media' => $media->id]) . '\')" >تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_media( '  . $media->id . ', \'' . route('media.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->addColumn('title', function ($order) {
                return $order->title;
            })
            ->addColumn('type', function ($order) {
                return $order->type ? $order->type : null;
            })
            ->addColumn('file', function ($order) {
                if ($order->files->first()) {
                    if ($order->files->first()->type == 'video') {
                        return '<video width="200" height="100" controls>
                                <source src="' . asset('storage/' . $order->files->first()->file) . '" type="video/mp4">
                                </video>';
                    }
                    return $order->files->first() ? '
                    <img style="width:200px;height:100px" src="' . asset('storage/' . $order->files->first()->file) . '">
                    ' : null;
                } else {
                    return null;
                }
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions', 'file'])
            ->make(true);
    }

    public function form($id = null)
    {
        $data['media'] = null;
        if ($id) {
            $data['media'] = Media::query()->findOrFail($id);
        }

        return response()->json([
            'page' => view('CP.media.form', $data)->render(),
            'success' => true
        ]);
    }

    public function add_edit(Request $request)
    { 
        $request->validate([
            'title' => 'nullable',
            'type' => 'required|in:image,video'
        ]);
        // if ($request->type == 'image') {
        //     $request->validate([
        //         'file' => 'array',
        //         'file.*' => 'required|image|mimes:png,jpg,jpeg|max:5000'
        //     ]);
        // } else {
        //     $request->validate([
        //         'file' => 'array',
        //         'file.*' => 'required|mimes:mp4,amv'
        //     ]);
        // }
        $id = isset($request['id']) ? $request['id'] : null;

        $data = $request->only('title', 'type');
        $media = Media::query()->updateOrCreate(['id' => $id], $data);

        if ($request->file('file')) {
            $old = File::where('item_id', $media->id)->whereIn('type', ['image', 'video'])->get();

            foreach ($old as $key => $value) {
                Storage::delete($value->file);
                $value->delete();
            }

            foreach ($request->file('file') as $value) {
                $item['file']    = $value->store('avatars', 'public');
                $item['type']    = $request->type;
                $item['item_id'] = $media->id;
                File::create($item);
            }
        }

        return response()->json([
            'success' => True,
            'message' => $id ? 'تم تعديل الخبر بنجاح' : 'تمت إضافة الخبر بنجاح'
        ]);
    }

    public function delete()
    {
        $media = Media::query()->findOrFail(request('id'))->first();
        File::where('item_id', $media->id)->whereIn('type', ['image', 'video'])->delete();
        $media->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف  بنجاح',
            'success' => true
        ]);
    }

    public function delete_img()
    {
        File::where('id', request('id'))->whereIn('type', ['image', 'video'])->delete();
        return true;
    }
}
