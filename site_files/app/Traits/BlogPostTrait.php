<?php
namespace App\Traits;
use App\Helpers\ImageUploader;
use Illuminate\Support\Facades\Auth;

trait BlogPostTrait
{
    private function setBlogPostValues($request, $blogPostObj)
    {
        $blogPostObj->author_id = Auth::user()->id;
        $blogPostObj->title = $request->input('title', '');
        $blogPostObj->cate_ids = implode(',', $request->input('cate_ids', ''));
        $blogPostObj->post_slug = $request->input('post_slug', '');
        $blogPostObj->description = $request->input('description', '');
        $blogPostObj->featured_img_title = $request->input('featured_img_title', '');
        $blogPostObj->featured_img_alt = $request->input('featured_img_alt', '');
        $blogPostObj->meta_title = $request->input('meta_title', $request->input('title', ''));
        $blogPostObj->meta_keywords = $request->input('meta_keywords', $request->input('title', ''));
        $blogPostObj->meta_description = $request->input('meta_description', $request->input('title', ''));
        $blogPostObj->canonical_url = $request->input('canonical_url', '');
        $blogPostObj->dated = $request->input('dated', date('Y-m-d H:i:s'));
        
        $blogPostObj = $this->setBlogPostImage($request, $blogPostObj);
        $blogPostObj = $this->setBlogPostStatus($request, $blogPostObj);
                
        return $blogPostObj;
    }
    private function setBlogPostImage($request, $blogPostObj)
    {
        if ($request->hasFile('featured_img')) {
            ImageUploader::deleteImage('blog', $blogPostObj->image, true);
            $image = $request->file('featured_img');
            $imageName = $request->input('title');
            $fileName = ImageUploader::UploadImage('blog', $image, $imageName, 1600, 1600, true);
            $blogPostObj->featured_img = $fileName;
        }
        return $blogPostObj;
    }
    private function setBlogPostStatus($request, $blogPostObj)
    {
        $blogPostObj->sts = $request->input('sts');
        return $blogPostObj;
    }
}
