<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\CmsModule;
use App\Models\Back\CmsModuleData;
use App\Models\Back\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;
        if (!IsNullOrEmptyString($query)) {
            $pages = Page::where('keyWords', 'LIKE', '%' . $query . '%')
                ->get(['id', 'keyWords', 'url']);
            $modules = CmsModule::where('title', 'LIKE', "%" . $query . '%')
                ->get(['id', 'title', 'type']);
            $cms = CmsModuleData::select('id', 'heading', 'cms_module_id')
                ->where('heading', 'LIKE', "%" . $query . '%')
                ->orWhere('content', 'LIKE', '%' . $query . '%')
                ->where('content_type', 'page')
                ->with(['module' => function ($query) {
                    $query->select('id', 'type');
                }])
                ->orderBy('item_order', "ASC")
                ->get();
            return json_encode(array('pages' => $pages, 'modules' => $modules, 'cms' => $cms));
        } else {
            return json_encode(array());
        }
    }
}
