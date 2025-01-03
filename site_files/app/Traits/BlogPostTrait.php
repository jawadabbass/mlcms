<?php
namespace App\Traits;
use App\Helpers\ImageUploader;
use Illuminate\Support\Facades\Auth;

trait BlogPostTrait
{
    private function setBlogPostValues($request, $blogPostObj)
    {        
        $blogPostObj->author_id = $request->input('author_id', Auth::user()->id);
        $blogPostObj->author_name = $request->input('author_name', Auth::user()->name);
        $blogPostObj->title = $request->input('title', '');
        $blogPostObj->cate_ids = implode(',', $request->input('cate_ids', ['1']));
        $blogPostObj->tags = implode(',', array_filter($request->input('tags', [])));
        $blogPostObj->post_slug = $request->input('post_slug', '');
        $blogPostObj->description = $request->input('description', '');
        $blogPostObj->featured_img = $request->input('featured_img', '');
        $blogPostObj->featured_img_title = $request->input('featured_img_title', '');
        $blogPostObj->featured_img_alt = $request->input('featured_img_alt', '');
        $blogPostObj->meta_title = $request->input('meta_title', $request->input('title', ''));
        $blogPostObj->meta_keywords = $request->input('meta_keywords', $request->input('title', ''));
        $blogPostObj->meta_description = $request->input('meta_description', $request->input('title', ''));
        $blogPostObj->canonical_url = $request->input('canonical_url', '');
        $blogPostObj->show_follow = $request->input('show_follow', 1);
        $blogPostObj->show_index = $request->input('show_index', 1);
        $blogPostObj->dated = $request->input('dated', date('Y-m-d H:i:s'));
        
        $blogPostObj = $this->setBlogPostStatus($request, $blogPostObj);
        $blogPostObj = $this->setBlogPostIsFeatured($request, $blogPostObj);
                
        return $blogPostObj;
    }
    private function setBlogPostStatus($request, $blogPostObj)
    {
        $blogPostObj->sts = $request->input('sts');
        return $blogPostObj;
    }
    private function setBlogPostIsFeatured($request, $blogPostObj)
    {
        $blogPostObj->is_featured = $request->input('is_featured', 0);
        return $blogPostObj;
    }
}
