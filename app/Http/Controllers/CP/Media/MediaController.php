<?php

namespace App\Http\Controllers\CP\Media;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
                return $order->type;
            })
            ->addColumn('file', function ($order) {

                if ($order->file) {
                    if ($order->type == 'video') {
                        return '<video width="200" height="100" controls>
                                <source src="' . asset('storage/' . $order->file) . '" type="video/mp4">
                                </video>';
                    }
                    return $order->file ? '
                    <img style="width:200px;height:100px" src="' . asset('storage/' . $order->file) . '">
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
            'title' => 'required',
            'type' => 'required|in:image,video'
        ]);
        if ($request->type == 'image') {
            $request->validate([
                'file' => 'required|image|mimes:png,jpg,jpeg|max:3000'
            ]);
        } else {
            $request->validate([
                'file' => 'required|mimes:mp4,amv|max:5000'
            ]);
        }
        $id = isset($request['id']) ? $request['id'] : null;
        $data = $request->except('_token');

        $data['file'] = $request->file('file')->store(
            'avatars',
            'public'
        );
        Media::query()->updateOrCreate(['id' => $id], $data);

        return response()->json([
            'success' => True,
            'message' => $id ? 'تم تعديل الخبر بنجاح' : 'تمت إضافة الخبر بنجاح'
        ]);
    }

    public function delete()
    {

        Media::query()->findOrFail(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف  بنجاح',
            'success' => true
        ]);
    }
}
