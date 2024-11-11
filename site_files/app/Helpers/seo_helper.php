<?php

use App\Models\Back\BlogPost;
use App\Models\Back\CmsModuleData;

if (!function_exists('seo_print')) {
	function seo_print($seoArr = [])
	{
		$url_full = url($_SERVER['REQUEST_URI']);
		$url_current = url()->current();
		$urlArray = explode('/', $url_current);
		$current_page_name = end($urlArray);
		$metaTags = '';
		$noFollowNoIndex = ['max-image-preview:large'];
		$og_image = FindInsettingArr('og_image');
		$og_image_str = '';
		if (!empty($og_image)) {
			$og_image_str = '<meta property="og:image" content="' . getImage('admin_logo_favicon', $og_image, 'main') . '" />' . "\r\n";
		}
		$metaTags .= '<meta property="og:locale" content="en_US" />' . "\r\n";
		$metaTags .= '<meta property="og:type" content="website" />' . "\r\n";
		$metaTags .= '<meta property="og:url" content="' . $url_current . '" />' . "\r\n";
		$metaTags .= $og_image_str;
		$metaTags .= '<meta name="twitter:card" content="summary" />' . "\r\n";
		if (isset($seoArr['title']) && $seoArr['title'] != '') {
			$title = $seoArr['title'];
		} else {
			$title = FindInsettingArr('business_name');
		}
		$metaTags .= '<title>' . $title . '</title>' . "\r\n";
		$metaTags .= '<meta property="og:title" content="' . $title . '"/>' . "\r\n";
		$metaTags .= '<meta property="twitter:title" content="' . $title . '"/>' . "\r\n";
		if (isset($seoArr['keywords']) && $seoArr['keywords'] != '') {
			$metaTags .= '<meta name="keywords" content="' . $seoArr['keywords'] . '">' . "\r\n";
		}
		if (isset($seoArr['descp']) && $seoArr['descp'] != '') {
			$description = $seoArr['descp'];
		} else {
			$description = $title;
		}
		$metaTags .= '<meta name="description" content="' . $description . '">' . "\r\n";
		$metaTags .= '<meta name="og:description" content="' . $description . '">' . "\r\n";
		$metaTags .= '<meta name="twitter:description" content="' . $description . '">' . "\r\n";
		$metaTags .= '<meta name="og:site_name" content="' . $description . '">' . "\r\n";
		if (isset($seoArr['canonical_url']) && $seoArr['canonical_url'] != '') {
			$metaTags .= '<link rel="canonical" href="' . $seoArr['canonical_url'] . '" />' . "\r\n";
		} else {
			$metaTags .= '<link rel="canonical" href="' . $url_full . '" />' . "\r\n";
		}
		$noFollowNoIndex[] = 'INDEX';
		if (isset($seoArr['index']) && $seoArr['index'] != '1') {
			$noFollowNoIndex[] = 'NOINDEX';
		}
		$noFollowNoIndex[] = 'FOLLOW';
		if (isset($seoArr['follow']) && $seoArr['follow'] != '1') {
			$noFollowNoIndex[] = 'NOFOLLOW';
		}
		$metaTags .= '<meta name="robots" content="' . implode(',', $noFollowNoIndex) . '">' . "\r\n";
		$metaTags .= '
        <script type="application/ld+json" class="aioseo-schema">
        {
            "@context": "https://schema.org",
            "@graph": [
                {
                    "@type": "WebSite",
                    "@id": "' . $url_current . '/#website",
                    "url": "' . $url_current . '/",
                    "name": "' . $title . '",
                    "description": "' . $description . '",
                    "inLanguage": "en-US",
                    "publisher": {
                        "@id": "' . $url_current . '/#organization"
                    },
                    "potentialAction": {
                        "@type": "SearchAction",
                        "target": {
                            "@type": "EntryPoint",
                            "urlTemplate": "' . base_url() . 'blog/search?s={search_term_string}"
                        },
                        "query-input": "required name=search_term_string"
                    }
                },
                {
                    "@type": "Organization",
                    "@id": "' . $url_current . '/#organization",
                    "name": "' . $description . '",
                    "url": "' . $url_current . '/"
                },
                {
                    "@type": "BreadcrumbList",
                    "@id": "' . $url_current . '/#breadcrumblist",
                    "itemListElement": [
                        {
                            "@type": "ListItem",
                            "@id": "' . $url_current . '/#listItem",
                            "position": 1,
                            "item": {
                                "@type": "WebPage",
                                "@id": "' . $url_current . '/",
                                "name": "' . $current_page_name . '",
                                "description": "' . $description . '",
                                "url": "' . $url_current . '/"
                            },
                            "nextItem": "' . $url_current . '/#listItem"
                        },
                        {
                            "@type": "ListItem",
                            "@id": "' . $url_current . '/#listItem",
                            "position": 2,
                            "item": {
                                "@type": "WebPage",
                                "@id": "' . $url_current . '/",
                                "name": "' . $current_page_name . '",
                                "description": "' . $description . '",
                                "url": "' . $url_current . '/"
                            },
                            "previousItem": "' . $url_current . '/#listItem"
                        }
                    ]
                },
                {
                    "@type": "WebPage",
                    "@id": "' . $url_current . '/#webpage",
                    "url": "' . $url_current . '/",
                    "name": "' . $title . '",
                    "description": "' . $description . '",
                    "inLanguage": "en-US",
                    "isPartOf": {
                        "@id": "' . $url_current . '/#website"
                    },
                    "breadcrumb": {
                        "@id": "' . $url_current . '/#breadcrumblist"
                    }
                }
            ]
        }    
        </script>';
		return $metaTags;
	}
}
function getSeoArrayModule($id)
{
	$moduleData = CmsModuleData::find($id);
	if (is_null($moduleData)) {
		return [
			'title' => '',
			'keywords' => '',
			'descp' => '',
			'canonical_url' => '',
			'index' => '',
			'follow' => '',
		];
	}
	return SeoArray($moduleData);
}
function getSeoArrayBlog($id)
{
	$moduleData = BlogPost::find($id);
	return SeoArray($moduleData);
}
function SeoArray($moduleData)
{
	$title = (isset($moduleData->meta_title) && !empty($moduleData->meta_title)) ? $moduleData->meta_title : '';
	$title = (empty($title) && !empty($moduleData->heading)) ? $moduleData->heading : $title;
	$keywords = (isset($moduleData->meta_keywords)) ? $moduleData->meta_keywords : '';
	$description = (isset($moduleData->meta_description)) ? $moduleData->meta_description : '';
	$canonical_url = (isset($moduleData->canonical_url)) ? $moduleData->canonical_url : '';
	$index = $moduleData->show_index;
	$follow = $moduleData->show_follow;
	$retArray = [
		'title' => $title,
		'keywords' => $keywords,
		'descp' => $description,
		'canonical_url' => $canonical_url,
		'index' => $index,
		'follow' => $follow,
	];
	return $retArray;
}
function seo_img_tags($imgName = '', $default = '', $is_dynamic = false)
{
	if (empty($default)) {
		$default = FindInsettingArr('business_name');
	}
	if ($is_dynamic) {
		return 'title="' . $default . '" alt="' . $default . '" loading="lazy"';
	}
	$seoImageArr = explode('/', $imgName);
	$seoImageArr = array_reverse($seoImageArr);
	if (isset($seoImageArr[0])) {
		$imgName = $seoImageArr[0];
	}
	$imageSeoArr =  CmsModuleData::where('sts', 1)
		->where('cms_module_id', 48)
		->where('heading', 'like', $imgName)
		->select('additional_field_1', 'additional_field_2', 'heading')
		->first();
	if (null === $imageSeoArr) {
		$imageSeoArr = new CmsModuleData();
		$imageSeoArr->cms_module_id = 48;
		$imageSeoArr->sts = 1;
		$imageSeoArr->heading = $imgName;
		$imageSeoArr->additional_field_1 = $default;
		$imageSeoArr->additional_field_2 = $default;
		$imageSeoArr->save();
	}
	return 'title="' . $imageSeoArr->additional_field_1 . '" alt="' . $imageSeoArr->additional_field_2 . '" loading="lazy"';
}
