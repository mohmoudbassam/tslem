<?php
namespace App\Http\Controllers\CP\NewsArticles;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\NewsArticle\StoreNewsArticleRequest;
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
     * @param $value
     *
     * @return mixed
     */
    public function list(Request $request)
    {
        $news_articles = NewsArticle::query()
            ->orderBy('created_at', data_get(collect($request->get('order', ['desc']))->first(), 'dir', 'desc'))
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
            ->addColumn('id', fn(NewsArticle $news_article) => $news_article->id)
            ->addColumn('title', fn(NewsArticle $news_article) => $news_article->title)
            ->addColumn('user_id', fn(NewsArticle $news_article) => $news_article->user()->value('name'))
            ->addColumn('actions', function ($news_article) {
                $title = __('general.datatable.fields.actions');
                $delete_title = NewsArticle::crudTrans('delete');
                $delete_route = route('news_articles.delete', ['news_article' => $news_article->id]);
                $update_title = NewsArticle::crudTrans('update');
                $update_route = route('news_articles.edit', ['news_article' => $news_article->id]);
                return <<<HTML
<div class="btn-group me-1 mt-2">
    <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {$title}<i class="mdi mdi-chevron-down"></i>
    </button>

    <div class="dropdown-menu" style="">
        <a class="dropdown-item" href="#" onclick="delete_model({$news_article->id}, '{$delete_route}')" >{$delete_title}</a>
        <a class="dropdown-item" href="{$update_route}">{$update_title}</a>
    </div>
</div>
HTML;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    /**
     * @post
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsArticle $news_article
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, NewsArticle $news_article)
    {
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
     * @param \App\Models\NewsArticle $news_article
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreNewsArticleRequest $request, NewsArticle $news_article)
    {
        $news_article->update($request->validated());
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
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images/news_articles'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/news_articles/'.$fileName);
            $msg = 'تم رفع الصورة بنجاح';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
