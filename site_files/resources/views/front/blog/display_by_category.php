<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <?php echo seo_print($seoArr); ?>
  <link href="<?php echo public_path_to_storage('module/blog/front/css/blog.css'); ?>" rel="stylesheet" type="text/css" />
  <?php $this->load->view('../../common_views/before_head_close'); ?>
</head>

<body>
  <!--header-->
  <?php $this->load->view('../../common_views/header'); ?>

  <div class="inner-page">
    <div class="container">

    </div>
  </div>

  <div class="about-wrap">
    <div class="container">

      <div class="col-md-9">
        <ul class="row articles-service">
          <?php if (isset($is_category_blogs) && $is_category_blogs === true) { ?>

            <?php foreach ($category_blogs as $blogsValues) { ?>
              <li class="col-md-12">
                <div class="inner-col">
                  <div class="articles-image">
                    <?php if (file_exists(storage_path_to_uploads('blog/thumb/'.$blogsValues['featured_img'])) && !empty($blogsValues['featured_img'])) { ?>
                      <img src="<?php echo public_path_to_uploads('blog/thumb/'.$blogsValues['featured_img']); ?>"  title="<?php echo $blogsValues['featured_img_title']; ?>"  alt="<?php echo $blogsValues['featured_img_alt']; ?>">
                    <?php } else { ?>
                      <img src="<?php echo public_path_to_uploads('images/admin_images/no_image.jpg'); ?>" title="<?php echo $blogsValues['featured_img_title']; ?>"  alt="<?php echo $blogsValues['featured_img_alt']; ?>">
                    <?php } ?>
                  </div>
                  <div class="head">
                    <a href="<?php echo base_url(); ?>blog/<?php echo $blogsValues['post_slug']; ?>.html" title="">
                      <?php echo $blogsValues['title']; ?>
                    </a>
                  </div>
                  <div class="blog-meta"> <span><i class="fa fa-clock-o"></i> <?php echo date('M d, Y ', strtotime($blogsValues['dated'])); ?></span> <span><i class="fa fa-user"></i> <?php echo $blogsValues['admin_name']; ?></span> </div>

                  <?php echo character_limiter($blogsValues['description'], 180); ?>
                  <a class="readmore" href="<?php echo base_url(); ?>blog/<?php echo $blogsValues['post_slug']; ?>.html">Continue Reading</a>
                  <div class="clearfix"></div>
                </div>
              </li>
          <?php
            }
          }
          ?>
          <div class="clearfix"></div>
        </ul>
        <div class="paginationWrap pull-right" style="">
          <?php echo ($category_blogs) ? $links : ''; ?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="collaps">

          <h3 class="newstitle">CATEGORIES</h3>
          <ul class="monthlynews">
            <?php if (isset($is_blog_cate) && $is_blog_cate === true) { ?>
              <?php foreach ($blog_categories as $blog_catValues) { ?>
                <li><a href="<?php echo base_url(); ?>blog/category/<?php echo $blog_catValues['cate_slug']; ?>.html"><?php echo $blog_catValues['cate_title']; ?></a></li>
            <?php }
            } ?>
          </ul>


        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('../../common_views/footer'); ?>
</body>

</html>