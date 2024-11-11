<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\News;
use App\Traits\NewsTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Back\NewsBackFormRequest;

class NewsController extends Controller
{
    use NewsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': News Management';
        $msg = '';

        return view('back.news.index', compact('title', 'msg'));
    }

    public function fetchNewsAjax(Request $request)
    {
        $news = News::select('*');

        return Datatables::of($news)
            ->filter(function ($query) use ($request) {
                if ($request->has('title') && !empty($request->title)) {
                    $query->where('news.title', 'like', "%{$request->get('title')}%");
                }
                if ($request->has('description') && !empty($request->description)) {
                    $query->where('news.description', 'like', "%{$request->get('description')}%");
                }
                if ($request->has('is_featured') && !empty($request->is_featured)) {
                    $query->where('news.is_featured', 'like', "{$request->get('is_featured')}");
                }
                if ($request->has('status') && $request->status != '') {
                    $query->where('news.status', $request->get('status'));
                }
            })
            ->addColumn('news_date_time', function ($news) {
                return date('m-d-Y H:i:s', strtotime($news->news_date_time));
            })
            ->addColumn('image', function ($news) {
                return '<img src="' . ImageUploader::print_image_src($news->image, 'news/thumb') . '" style="max-width:165px !important; max-height:165px !important;"/>';
            })
            ->addColumn('status', function ($services) {
                $checked = ($services->status) == 1 ? ' checked' : '';

                $str = '<input type="checkbox" data-toggle="toggle_status" data-onlabel="Active"
                data-offlabel="Not Active" data-onstyle="success"
                data-offstyle="danger"
                data-id="' . $services->id . '"
                name="status_' . $services->id . '"
                id="status_' . $services->id . '" ' . $checked . '
                value="' . $services->status . '">';
                return $str;
            })
            ->addColumn('description', function ($news) {
                $str = Str::limit(strip_tags($news->description), 200, '...');
                return $str;
            })
            ->addColumn('action', function ($news) {
                return '
                		<a href="' . route('news.edit', ['newsObj' => $news->id]) . '" class="btn btn-warning m-2"><i class="fas fa-edit" aria-hidden="true"></i></a>
						<a href="javascript:void(0);" onclick="deleteNews(' . $news->id . ');"  class="btn btn-danger m-2"><i class="fas fa-trash" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['news_date_time', 'image', 'status', 'action'])
            ->orderColumns(['news_date_time', 'title', 'description', 'status'], ':column $1')
            ->setRowId(function ($news) {
                return 'newsDtRow' . $news->id;
            })
            ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    /**
     * Show the form for creating a news resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = FindInsettingArr('business_name') . ': News Management';
        $msg = '';
        $newsObj = new News();

        return view('back.news.create')
            ->with('newsObj', $newsObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Store a newsly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NewsBackFormRequest $request)
    {
        $newsObj = new News();
        $newsObj = $this->setNewsValues($request, $newsObj);
        $newsObj->save();

        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $newsObj->id,
            'record_title' => $newsObj->title,
            'model_or_table' => 'News',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($newsObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */

        session(['message' => 'News has been added!', 'type' => 'success']);

        return Redirect::route('news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(News $newsObj)
    {
        $title = FindInsettingArr('business_name') . ': News Management';
        $msg = '';

        return view('back.news.edit')
            ->with('newsObj', $newsObj)
            ->with('title', $title)
            ->with('msg', $msg);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NewsBackFormRequest $request, News $newsObj)
    {
        $newsObj = $this->setNewsValues($request, $newsObj);
        $newsObj->save();
        /******************************* */
        /******************************* */
        $recordUpdateHistoryData = [
            'record_id' => $newsObj->id,
            'record_title' => $newsObj->title,
            'model_or_table' => 'News',
            'admin_id' => auth()->user()->id,
            'ip' => request()->ip(),
            'draft' => json_encode($newsObj->toArray()),
        ];
        recordUpdateHistory($recordUpdateHistoryData);
        /******************************* */
        /******************************* */
        session(['message' => 'News has been updated!', 'type' => 'success']);
        return Redirect::route('news.index');
    }

    public function sortNews()
    {
        $title = FindInsettingArr('business_name') . ': News Management';
        $msg = '';

        return view('back.news.sort')->with('title', $title)
            ->with('msg', $msg);
    }

    public function newsSortData(Request $request)
    {
        $news = News::select('news.id', 'news.title', 'news.sort_order')
            ->orderBy('sort_order', 'ASC')->get();
        $str = '<ul id="sortable">';
        if ($news != null) {
            foreach ($news as $newsObj) {
                $str .= '<li class="ui-state-default" id="' . $newsObj->id . '"><i class="fas fa-sort"></i> ' . $newsObj->title . '</li>';
            }
        }
        echo $str . '</ul>';
    }

    public function newsSortUpdate(Request $request)
    {
        $newsOrder = $request->input('newsOrder');
        $newsOrderArray = explode(',', $newsOrder);
        $count = 1;
        foreach ($newsOrderArray as $newsId) {
            $newsObj = News::find($newsId);
            $newsObj->sort_order = $count;
            $newsObj->update();
            ++$count;
        }
    }

    public function updateNewsStatus(Request $request)
    {
        $newsObj = News::find($request->id);
        $newsObj = $this->setNewsStatus($request, $newsObj);
        $newsObj->save();
        echo 'Done Successfully!';
        exit;
    }

    public function destroy(News $newsObj)
    {
        ImageUploader::deleteImage('news', $newsObj->image, true);
        $newsObj->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        echo 'ok';
    }
}
