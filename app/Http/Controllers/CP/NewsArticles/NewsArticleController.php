<?php

namespace App\Http\Controllers\CP\NewsArticles;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\NewsArticle\StoreNewsArticleRequest;
use App\Models\File;
use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

/**
 * Class NewsArticleController
 *
 * @package App\Http\Controllers
 */
class NewsArticleController extends Controller
{
    /**
     * @param $value
     *
     * @return string
     */
    public static function makeTd($value)
    {
        return "\t\t\t<td>{$value}</td>\n";
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function makeTr($value)
    {
        return "\t\t<tr>\n{$value}\n\t\t</tr>\n";
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public static function makeTable($value)
    {
        if (is_array($value)) {
            $table_content = ["", ""];

            foreach ($value as $k => $v) {
                $table_content[0] .= static::makeTd($k);
                $table_content[1] .= static::makeTd($v);
            }

            return static::makeTable(static::makeTr($table_content[0]) . static::makeTr($table_content[1]));
        }

        return static::makeTable($value);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('CP.news_articles.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(Request $request)
    {
        return view('CP.news_articles.form', [
            'mode' => 'create',
            'mode_form' => 'store',
            'model' => null,
        ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\NewsArticle\StoreNewsArticleRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNewsArticleRequest $request)
    {
        $data = $request->validated();
        $data['order_id'] ??= 0;
        $news_article = NewsArticle::create($data);
        if ($request->file('image')) {
            foreach ($request->file('image') as $value) {
                $item['file']    = $value->store('news_articles', 'public');
                $item['type']    = 'news';
                $item['item_id'] = $news_article->id;
                File::create($item);
            }
        }

        return redirect()
            ->route('news_articles')
            ->with(['success' => __('general.success')]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsArticle  $news_article
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, NewsArticle $news_article)
    {
        return view('CP.news_articles.form', [
            'mode' => 'update',
            'mode_form' => 'update',
            'model' => $news_article,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsArticle  $news_article
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function article(NewsArticle $news_article)
    {
        $news_articles = [];
        if ($news_article && $news_article->body) $news_article->body = nl2br($news_article->body);
        $news_articles['model'] = $news_article;
        $news_articles['news'] =  \App\Models\News::query()->latest()->get();
        $news_articles['pageTitle'] = $news_article && $news_article->title ? 'الأخبار - ' . $news_article->title : trans('general.something_went_wrong');
        return view("news_article_show", $news_articles);
    }
    /**
     * @param $value
     *
     * @return mixed
     */
    public function list(Request $request)
    {
        $order = collect($request->get('order', ['desc']))->first();
        $order_by_index = data_get($order, 'column', -1);
        $order_by = (NewsArticle::$LIST_COLUMNS[$order_by_index] ?? 'created_at');

        $news_articles = NewsArticle::query()
            ->orderBy($order_by ?: 'created_at',  data_get($order, 'dir', 'desc'))
            ->when(request('name'), function ($query) {
                return $query->where(function (Builder $q) {
                    $columns = ['id', 'title',];
                    foreach ($columns as $column) {
                        $q = $q->orWhere($column, 'like', '%' . request('name') . '%');
                    }

                    return $q;
                });
            });

        return DataTables::of($news_articles)
            ->addColumn('id', fn (NewsArticle $news_article) => $news_article->id)
            ->addColumn('title', fn (NewsArticle $news_article) => $news_article->title)
            ->addColumn('user_id', fn (NewsArticle $news_article) => $news_article->user()->value('name') ?: '-')
            ->addColumn('is_published', fn (NewsArticle $news_article) => $news_article::trans($news_article->is_published ? 'published' : 'not_published'))
            ->addColumn('image', function ($order) {
                return $order->image ? '
                            <img style="width:50px" src="' . asset('storage/' . $order->image) . '">
                            ' : null;
            })
            ->addColumn('actions', function ($news_article) {
                $title = __('general.datatable.fields.actions');
                $delete_title = NewsArticle::crudTrans('delete');
                $delete_route = route('news_articles.delete', ['news_article' => $news_article->id]);
                $update_title = NewsArticle::crudTrans('update');
                $update_route = route('news_articles.edit', ['news_article' => $news_article->id]);
                $publish_route = route('news_articles.toggle_publish', ['news_article' => $news_article->id]);
                $publish_title = NewsArticle::trans($news_article->is_published ? 'unpublish' : 'publish');
                $publish = "<a class='dropdown-item' onclick='publish_model({$news_article->id}, \"{$publish_route}\")' href='#'>{$publish_title}</a>";

                return <<<HTML
                <div class="btn-group me-1 mt-2">
                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {$title}<i class="mdi mdi-chevron-down"></i>
                    </button>

                    <div class="dropdown-menu" style="">
                        <a class="dropdown-item" href="#" onclick="delete_model({$news_article->id}, '{$delete_route}')" >{$delete_title}</a>
                        <a class="dropdown-item" href="{$update_route}">{$update_title}</a>
                        {$publish}
                    </div>
                </div>
                HTML;
            })
            ->rawColumns(['actions', 'image'])
            ->make(true);
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function Mainlist(Request $request)
    {
        $articles = NewsArticle::query()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
        if (!$articles) {
            $articles = [];
        }

        $news_articles = [];
        $news_articles['links'] = $articles;
        $news_articles['news'] =  \App\Models\News::query()->latest()->get();
        $news_articles['pageTitle'] = 'المركز الإعلامي - الأخبار';
        return view("news_articles", $news_articles);
    }
    /**
     * @post
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsArticle  $news_article
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, NewsArticle $news_article)
    {
        File::where('item_id', $news_article->id)->where('type', 'news')->delete();
        
        $news_article->delete();

        return response()->json([
            'message' => __('general.success'),
            'success' => true,
        ]);
    }

    /**
     * @post
     *
     * @param \App\Http\Requests\CP\NewsArticle\StoreNewsArticleRequest $request
     * @param \App\Models\NewsArticle                                   $news_article
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreNewsArticleRequest $request, NewsArticle $news_article)
    {
        $data = $request->validated();
        $news_article->update($data);

        if ($request->file('image')) {

            $old = File::where('item_id', $news_article->id)->where('type', 'news')->get();

            foreach ($old as $key => $value) {
                Storage::delete($value->file);
                $value->delete();
            }

            foreach ($request->file('image') as $value) {
                $item['file']    = $value->store('news_articles', 'public');
                $item['type']    = 'news';
                $item['item_id'] = $news_article->id;
                File::create($item);
            }
        }

        return back()->with('success', __('general.success'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsArticle  $news_article
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_image_path(Request $request, NewsArticle $news_article)
    {
        $news_article->deleteImagePathFile(true);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المرفق بنجاح',
        ]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images/news_articles'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/news_articles/' . $fileName);
            $msg = 'تم رفع الصورة بنجاح';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function togglePublish(Request $request, NewsArticle $news_article)
    {
        $news_article->togglePublish(true);

        return response()->json([
            'success' => true,
            'message' => 'تمت العملية بنجاح',
        ]);
    }
}
