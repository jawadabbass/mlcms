<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Back\CmsModuleData;
use App\Models\Back\CmsModule;
use App\Models\Back\Metadata;
use Illuminate\Http\Request;
use App\Models\Back\MenuType;
use App\Models\Back\Image;
use App\Models\Back\Album;
use App\Models\Back\BlogPost;
use App\Models\Back\BlogCategory;
use App\Models\Back\FleetCategory;
use App\Models\Back\FleetPlane;
use App\Models\Back\Subscribers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //if(Cache::has('home') && Auth::check()==false){return Cache::get('home'); }

        $news_results =  get_all(32, NULL, 3);  // (limit,start,module_id)
        $tesimonialsArr = get_alls(15, NULL, 22);
        $seoArr = getSeoArrayModule(151);
        $blogData =
            BlogPost::where('sts', 'active')->orderBy('dated', 'DESC')->limit(3)->get();
        $get_all_banner =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 2)
            ->orderBy('ID', 'DESC')
            ->limit(3)
            ->get();
        $get_all_features =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 35)
            ->orderBy('item_order', 'ASC')
            ->limit(4)
            ->get();
        $get_all_services =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 33)
            ->orderBy('ID', 'ASC')
            ->limit(10)
            ->get();
        $get_all_testimonials =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 22)
            ->orderBy('ID', 'ASC')
            ->limit(10)
            ->get();
        $get_all_faqs =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 19)
            ->orderBy('ID', 'ASC')
            ->limit(10)
            ->get();
        $get_all_partners =  CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 34)
            ->orderBy('ID', 'ASC')
            ->limit(10)
            ->get();
        $albums = Album::paginate(20);
        $images = Image::paginate(20);
        return view('front.home.index', compact('news_results', 'seoArr', 'tesimonialsArr', 'blogData', 'get_all_banner', 'get_all_features', 'get_all_services', 'albums', 'images', 'get_all_testimonials', 'get_all_faqs', 'get_all_partners'));
        // $html=view('front.home.index',compact('news_results', 'seoArr','tesimonialsArr','blogData'))->render();

        // $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        // $html = $parser->compress($html);
        // if(Auth::check()==false){
        // Cache::put('home', $html,cacheTime());
        // }
        return $html;
    }
    public function aboutUs()
    {
        if (Cache::has('page_234') && Auth::check() == false) {
            return Cache::get('page_234');
        }
        $about = CmsModuleData::where('id', '104')->firstOrFail();
        $seoArr = SeoArray($about);

        $html = view('front.home.about-us', compact('about', 'seoArr'))->render();
        $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        $html = $parser->compress($html);
        if (Auth::check() == false) {
            Cache::put('page_234', $html, cacheTime());
        }
        return $html;
    }
    public function FAQs()
    {
        if (Cache::has('page_272') && Auth::check() == false) {
            return Cache::get('page_272');
        }
        $about = CmsModuleData::where('id', '272')->firstOrFail();
        $seoArr = SeoArray($about);
        $faqsArr = get_alls(500, 0, 19);
        $html = view('front.home.faqs', compact('about', 'seoArr', 'faqsArr'))->render();
        $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        $html = $parser->compress($html);
        if (Auth::check() == false) {
            Cache::put('page_272', $html, cacheTime());
        }
        return $html;
    }
    public function Portfolio()
    {
        if (Cache::has('page_223') && Auth::check() == false) {
            return Cache::get('page_223');
        }
        $page = CmsModuleData::where('id', '223')->firstOrFail();
        $seoArr = SeoArray($page);
        $portfoliArr = get_alls(8000, 0, 36);
        $html =  view('front.home.portfolio', compact('page', 'seoArr', 'portfoliArr'))->render();
        $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        $html = $parser->compress($html);
        if (Auth::check() == false) {
            Cache::put('page_223', $html, cacheTime());
        }
        return $html;
    }

    public function page($slug)
    {
        if (Cache::has($slug)) {
            return Cache::get($slug);
        }
        $data = CmsModuleData::where('post_slug', $slug)->first();
        if ($data != null) {
            $module = CmsModule::where('type', 'cms')->first();
            $menu_types = MenuType::orderBy('id', 'ASC')->get();
            $seoArr = getSeoArrayModule($data->id);
            $editPageID = $data->id;
            if ($data->cms_module_id == 33) {
                return view('front.home.full', compact('data', 'seoArr', 'module', 'menu_types', 'editPageID'));
            } else {
                // return view('front.home.page', compact('data', 'seoArr','module','menu_types','editPageID'));
                $html = view('front.home.page', compact('data', 'seoArr', 'module', 'menu_types', 'editPageID'))->render();
                $parser = \WyriHaximus\HtmlCompress\Factory::construct();
                $html = $parser->compress($html);
                Cache::put($slug, $html, cacheTime());
                return $html;
            }
            $html = view('front.home.page', compact('data', 'seoArr', 'module', 'menu_types', 'editPageID'))->render();
            $parser = \WyriHaximus\HtmlCompress\Factory::construct();
            $html = $parser->compress($html);
            Cache::put($slug, $html, cacheTime());
            return $html;
        } else {
            $BlogPost = BlogPost::where('post_slug', $slug)->where('sts', 'active')->first();
            if ($BlogPost) {

                $obj_result = BlogPost::with('author', 'comments')->where('post_slug', $slug)->first();
                if (isset($obj_result->title)) {
                    $seoArr = getSeoArrayBlog($obj_result->ID);
                    $blog_post_details = $obj_result;
                    $blog_comments = $obj_result->comments;
                    $blog_categories = BlogCategory::all();
                    return view('front.blog.show', compact('seoArr', 'blog_post_details', 'blog_comments', 'blog_categories'));
                }
            } {
                $seoArr = array('title' => '404 Not found ');
                return view('front.home.404', compact('seoArr'));
            }
        }
    }
    public function Other_pages($parent, $slug)
    {
        $dataArr = get_one($parent, $slug);
        if (isset($dataArr['heading'])) {

            $data = (object)$dataArr;
            $seoArr = SeoArray($data);
            $editPageID = $data->id;
            return view('front.home.other', compact('data', 'seoArr', 'module', 'menu_types', 'editPageID'));
        } else {
            $seoArr = array('title' => '404 Not found ');
            return view('front.home.404', compact('seoArr'));
        }
    }
    public function login()
    {
        $seoArr = array('title' => 'Welcome to ' . config('Constants.SITE_NAME'));
        return view('front.member.login', compact('seoArr'));
    }
    public function signup()
    {
        $seoArr = array('title' => 'Welcome to ' . config('Constants.SITE_NAME'));
        return view('front.member.register', compact('seoArr'));
    }
    public function maintenance()
    {
        $settingsArr = \App\Models\Back\Setting::find(1);
        echo $settingsArr->web_down_msg;
    }
    public function block(Request $request)
    {
        $data = Metadata::where('data_key', 'web_blocked_msg')->first();
        $seoArr = array('title' => 'Welcome to ' . config('Constants.SITE_NAME'));
        return view('front.home.error', compact('data', 'seoArr'));
    }
    public function addSubscriber(Request $request)
    {

        $valid_error = $this->validate($request, [
            'email' => 'required|unique:subscribers'
        ]);
        if (isset($valid_error)) {
            $subscriber = new Subscribers();
            $subscriber->email = $request->email;
            $subscriber->save();
            Session::flash('added_subscriber', true);
        } else {
            Session::flash('subscriber_error', true);
        }

        //return redirect(url()->previous().'#subscribe');
        return back();
    }
}
