<?php
namespace App\Traits;
use App\Helpers\ImageUploader;
use App\Models\Back\BlogCategory;
use Illuminate\Support\Facades\Auth;

trait BlogCategoryTrait
{
    private function setBlogCategoryValues($request, $blogCategoryObj)
    {        
        $blogCategoryObj->cate_title = $request->input('cate_title', '');
        $blogCategoryObj->cate_slug = $request->input('cate_slug', '');
        $blogCategoryObj->cate_description = $request->input('cate_description', '');
        $blogCategoryObj->featured_img = $request->input('featured_img', '');
        $blogCategoryObj->featured_img_title = $request->input('featured_img_title', '');
        $blogCategoryObj->featured_img_alt = $request->input('featured_img_alt', '');
        
        $blogCategoryObj = $this->setBlogCategoryStatus($request, $blogCategoryObj);
        $blogCategoryObj = $this->setBlogCategoryIsFeatured($request, $blogCategoryObj);
        $blogCategoryObj = $this->setBlogCategoryShowInHeader($request, $blogCategoryObj);
                
        return $blogCategoryObj;
    }
    private function setBlogCategoryStatus($request, $blogCategoryObj)
    {
        $blogCategoryObj->sts = $request->input('sts');
        return $blogCategoryObj;
    }
    private function setBlogCategoryIsFeatured($request, $blogCategoryObj)
    {
        BlogCategory::where('is_featured', 1)->update(['is_featured'=>0]);
        $blogCategoryObj->is_featured = $request->input('is_featured', 0);
        return $blogCategoryObj;
    }
    private function setBlogCategoryShowInHeader($request, $blogCategoryObj)
    {
        $blogCategoryObj->show_in_header = $request->input('show_in_header', 0);
        return $blogCategoryObj;
    }
}
