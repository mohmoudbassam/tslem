<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;

use App\Models\News;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use function Symfony\Component\Translation\t;

class NewsController extends Controller
{
    public function index()
    {
        return view('CP.News.index');
    }

    public function list()
    {
        $news = News::query();

//        dd($order->get());
        return DataTables::of($news)
            ->addColumn('actions', function ($news) {

                $element = '<div class="btn-group me-1 mt-2">
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                خيارات<i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item" href="javascript:;" onclick="showModal(\'' . route('news.form', ['news' =>$news->id]) . '\')" >تعديل</a>
                                                <a class="dropdown-item" href="#" onclick="delete_news( '  . $news->id . ', \'' . route('news.delete') . '\')" >حذف</a>
                                            </div>
                                        </div>';

                return $element;
            })
            ->addColumn('created_at', function ($order) {
                return $order->created_at->format('Y-m-d');
            })->rawColumns(['actions'])
            ->make(true);
    }

    public function form($id = null)
    {
        $data['news'] = null;
        if ($id) {
            $data['news'] = News::query()->findOrFail($id);
        }

        return response()->json([
            'page' => view('CP.News.form', $data)->render(),
            'success' => true
        ]);
    }

    public function add_edit(Request $request)
    {
        $id = isset($request['id']) ? $request['id'] : null;

         News::query()->updateOrCreate(['id' => $id], $request->except('_token'));

        return response()->json([
            'success' => True,
            'message' => $id ? 'تم تعديل الخبر بنجاح' : 'تمت إضافة الخبر بنجاح'
        ]);
    }

    public function delete(){

        News::query()->findOrFail(request('id'))->delete();
        return response()->json([
            'message' => 'تمت عمليه الحذف  بنجاح',
            'success' => true
        ]);
    }
}
