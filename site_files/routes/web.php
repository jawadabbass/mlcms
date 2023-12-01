<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Back\CacheController;
use App\Http\Controllers\Back\FilesController;
use App\Http\Controllers\Back\MediaController;
use App\Http\Controllers\Back\ThemeController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Back\CareerController;
use App\Http\Controllers\Back\ClientController;
use App\Http\Controllers\Back\ModuleController;
use App\Http\Controllers\Back\SearchController;
use App\Http\Controllers\Back\WidgetController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Back\SettingController;
use App\Http\Controllers\Back\SiteMapController;
use App\Livewire\Back\BannerPopups\BannerPopupsList;
use App\Http\Controllers\Back\AdminLogController;
use App\Http\Controllers\Back\ContactFormSetting;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Front\GalleryCFrontoller;
use App\Http\Controllers\Front\ServicesController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\MailChimpController;
use App\Http\Controllers\Back\ImageUploadController;
use App\Http\Controllers\Back\ContactPagesController;
use App\Http\Controllers\Back\ModuleManageController;
use App\Http\Controllers\Front\TestimonialController;
use App\Http\Controllers\Back\PaymentOptionController;
use App\Http\Controllers\Back\Email_templatesController;
use App\Http\Controllers\Back\BlogController as BackBlogController;
use App\Http\Controllers\HomeController as UserDashboardController;
use App\Http\Controllers\Back\VideoController as BackVideoController;
use App\Http\Controllers\Back\GalleryController as BackGalleryController;
use App\Http\Controllers\Back\InvoiceController as BackInvoiceController;
use App\Http\Controllers\Back\ContactUsController as BackContactUsController;
use App\Http\Controllers\AdminAuth\LoginController as AdminAuthLoginController;
use App\Http\Controllers\AdminAuth\VerificationController as AdminAuthVerificationController;
use App\Http\Controllers\AdminAuth\ResetPasswordController as AdminAuthResetPasswordController;
use App\Http\Controllers\AdminAuth\ForgotPasswordController as AdminAuthForgotPasswordController;
use App\Http\Controllers\AdminAuth\ConfirmPasswordController as AdminAuthConfirmPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::prefix('adminmedia')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthLoginController::class, 'login']);
    Route::post('logout', [AdminAuthLoginController::class, 'logout'])->name('logout');
    Route::get('password/reset', [AdminAuthForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AdminAuthForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AdminAuthResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AdminAuthResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/confirm', [AdminAuthConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [AdminAuthConfirmPasswordController::class, 'confirm']);
    Route::get('email/verify', [AdminAuthVerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [AdminAuthVerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [AdminAuthVerificationController::class, 'resend'])->name('verification.resend');
});
Route::group(['prefix' => 'member', 'name' => 'member', 'middleware' => ['auth', 'ipmiddleware']], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
});
Route::group(['namespace' => 'Front', 'middleware' => ['siteStatus', 'clearCache', 'ipmiddleware']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('web.index');
    Route::get('/about-us', [HomeController::class, 'aboutUs']);
    Route::get('/atlanta_webdesign_portfolio.html', [HomeController::class, 'Portfolio'])->name('portfolio');
    Route::get('/frequently_asked_questions', [HomeController::class, 'FAQs']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{year}/{month}', [NewsController::class, 'page']);
    Route::get('/news-details/{id}/{slug}', [NewsController::class, 'single']);
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact');
    Route::post('/contact-us', [ContactUsController::class, 'save']);
    Route::get('/refresh', [ContactUsController::class, 'refresh']);
    Route::get('/blog/category/{slug}', [BlogController::class, 'category']);
    Route::get('/blog/search', [BlogController::class, 'search']);
    Route::resource('/blog', '\App\Http\Controllers\Front\BlogController');
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::post('/addSubscriber', [HomeController::class, 'addSubscriber']);
    Route::get('/services/{slug}', [ServicesController::class, 'show']);
    Route::get('/services', [ServicesController::class, 'index']);
    Route::get('/invoice/{slug}', [InvoiceController::class, 'paypal']);
    Route::get('/invoice/cancel/{slug}', [InvoiceController::class, 'payment_cancel']);
    Route::get('/invoice/success/{slug}', [InvoiceController::class, 'payment_success']);
    Route::get('/invoice/pay/{slug}', [InvoiceController::class, 'authorize_net']);
    Route::post('/invoice/pay/post', [InvoiceController::class, 'post_authorize_net']);
    //Stripe
    Route::get('stripe', [InvoiceController::class, 'stripe']);
    Route::post('stripe', [InvoiceController::class, 'stripePost'])->name('stripe.post');
    Route::get('/getState/{ads}', 'ClientRegisterController@getState')->name('get_state');
    Route::get('/getCity/{ads}', 'ClientRegisterController@getCity')->name('get_city');
    Route::get('updateMailChimpListMembers', [MailChimpController::class, 'updateMailChimpListMembers'])->name('updateMailChimpListMembers');
    Route::get('getMailChimpListMembers', [MailChimpController::class, 'getMailChimpListMembers'])->name('getMailChimpListMembers');
    Route::get('testUpdateMailChimpListMember', [MailChimpController::class, 'testUpdateMailChimpListMember'])->name('testUpdateMailChimpListMember');
    Route::get('testRemoveMailChimpListMember', [MailChimpController::class, 'testRemoveMailChimpListMember'])->name('testRemoveMailChimpListMember');
    Route::post('subscribe-newsletter', [MailChimpController::class, 'subscribeNewsletter'])->name('subscribeNewsletter');
    Route::get('subscribe-newsletter-thanks', [MailChimpController::class, 'subscribeNewsletterThanks'])->name('subscribeNewsletterThanks');
    Route::get('unsubscribe-newsletter', [MailChimpController::class, 'unsubscribeNewsletterForm'])->name('unsubscribeNewsletterForm');
    Route::post('unsubscribe-newsletter', [MailChimpController::class, 'unsubscribeNewsletter'])->name('unsubscribeNewsletter');
    Route::get('unsubscribe-newsletter-thanks', [MailChimpController::class, 'unsubscribeNewsletterThanks'])->name('unsubscribeNewsletterThanks');
});
Route::group(['namespace' => 'Back', 'prefix' => 'adminmedia', 'middleware' => ['admin_auth', 'ipmiddleware']], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/aaa', function () {
        return view('back.common_views.script');
    });
    Route::get('/run_script', [ModuleManageController::class, 'run_script']);
    //Career
    Route::get('job_share_on_pp/{slug}', [CareerController::class, 'shareOnPakPosition'])->name('job_share_on_pp');
    Route::get('job_change_sts_on_pp/{slug}', [CareerController::class, 'changeStsOnPakPos'])->name('job_change_sts_on_pp');
    Route::get('updateJobOnPakPosition/{slug}', [CareerController::class, 'updateJobOnPakPosition'])->name('updateJobOnPakPosition');
    Route::get('shareJobOnLinkedIn/{slug}', [CareerController::class, 'shareJobOnLinkedIn'])->name('shareJobOnLinkedIn');
    Route::get('deletePostOnLinkedin/{slug}', [CareerController::class, 'deletePostOnLinkedin'])->name('deletePostOnLinkedin');
    Route::get('jobs_applicants', [CareerController::class, 'jobs_applicants']);
    Route::get('jobs_applicants_details/{slug}', [CareerController::class, 'jobs_applicants_details']);
    Route::get('/jobCommonContact', 'ModuleManageController@contact_single_job');
    Route::post('/jobCommonContactSave', [ModuleManageController::class, 'commonContactSave'])->name('job.common.contact.save');
    Route::resource('/modules', '\App\Http\Controllers\Back\ModuleController');
    Route::get('/module/ordering/{type}', [ModuleManageController::class, 'showOrderPage']);
    Route::get('/module/ordering-set/{type}', [ModuleManageController::class, 'saveOrdering']);
    Route::resource('/module/{type}/', '\App\Http\Controllers\Back\ModuleManageController');
    Route::get('/module/{type}/add', [ModuleManageController::class, 'add_single_module']);
    Route::get('/module/{type}/edit/{id}', [ModuleManageController::class, 'edit_single_module']);
    Route::get('/module/{type}/{id}/edit', [ModuleManageController::class, 'edit']);
    Route::post('/module/{type}/{id}/', [ModuleManageController::class, 'update']);
    Route::delete('/module/delete/{id}/', [ModuleManageController::class, 'destroy']);
    Route::get('/modul/remove_image', [ModuleManageController::class, 'removeFeaturedImage']);
    Route::post('/modul/crop_image', [ModuleManageController::class, 'ajax_crop_img']);
    Route::post('/module_image/upload_image', [ImageUploadController::class, 'store']);
    Route::post('uploadCkeditorImage', [ImageUploadController::class, 'uploadCkeditorImage'])->name('uploadCkeditorImage');
    Route::post('/module_image/remove_image', [ImageUploadController::class, 'removeUploadedImage']);
    Route::post('/module_image/upload_more_images', [ImageUploadController::class, 'uploadMoreImages']);
    Route::post('/save_module_data_image_crop_image', [ModuleManageController::class, 'ajax_crop_module_data_img']);
    Route::post('/getModuleDataImageAltTitle', [ModuleManageController::class, 'getModuleDataImageAltTitle']);
    Route::post('/saveModuleDataImageAltTitle', [ModuleManageController::class, 'saveModuleDataImageAltTitle']);
    Route::post('/modules/updatePageOptions', [ModuleController::class, 'updatePageOptions']);
    Route::post('/payment_options/paypal_email', [PaymentOptionController::class, 'paypal_email']);
    Route::post('/payment_options/authorize_net', [PaymentOptionController::class, 'authorize_net']);
    Route::post('/payment_options/status', [PaymentOptionController::class, 'status']);
    Route::resource('/payment_options', '\App\Http\Controllers\Back\PaymentOptionController');
    Route::post('/invoice/status', [BackInvoiceController::class, 'status']);
    Route::get('/invoice/invoice_test', [BackInvoiceController::class, 'demo_invoice']);
    Route::get('/invoice/send_invoice', [BackInvoiceController::class, 'create_invoice']);
    Route::post('/invoice/post_send_invoice', [BackInvoiceController::class, 'post']);
    Route::post('/invoice/re_send_invoice', [BackInvoiceController::class, 're_send_invoice']);
    Route::resource('/invoice', '\App\Http\Controllers\Back\InvoiceController');
    Route::resource('/menus', '\App\Http\Controllers\Back\MenuController');
    Route::resource('/contact_request', '\App\Http\Controllers\Back\ContactUsController');
    Route::get('/contact_request/convert_client/{id}', [BackContactUsController::class, 'convert_client'])->name('lead_convert_client');
    //Contact us leads
    Route::get('/contact_request/export/{exportType}', 'ContactUsController@exportLeads')->name('export.leads');
    Route::post('/contact_request/lead_comment', [BackContactUsController::class, 'CommentContactLeads'])->name('lead_comments');
    Route::get('/read_data_contact_lead/{id}', [BackContactUsController::class, 'contactUsReadData'])->name('contact_lead_read');
    Route::post('/contact-request-bulk-actions', [BackContactUsController::class, 'contactUsBulkActions'])->name('contact_request.bulk.actions');
    Route::post('/contact_request/price', [BackContactUsController::class, 'PriceContactLeads'])->name('lead_price');
    Route::get('/get_contact_request_to_edit/{id}', [BackContactUsController::class, 'getContactRequestToEdit'])->name('get_contact_request_to_edit');
    Route::post('/update_contact_request', [BackContactUsController::class, 'updateContactRequest'])->name('update_contact_request');
    Route::post('/manage_clients/status', [ClientController::class, 'status']);
    Route::resource('/manage_clients', '\App\Http\Controllers\Back\ClientController');
    Route::post('/client_comments/request_comment', [ClientController::class, 'CommentContactClients'])->name('client_comments');
    Route::resource('/manage_contact', '\App\Http\Controllers\Back\ContactPagesController');
    Route::resource('/contact_form_settings', '\App\Http\Controllers\Back\ContactFormSetting');
    Route::post('/contact_form_settings/spam', [ContactFormSetting::class, 'update_spam_words']);
    Route::post('/manage_contacts/emails', [ContactPagesController::class, 'emailUpdate']);
    Route::post('/manage_contacts/email_delete', [ContactPagesController::class, 'emailDelete']);
    Route::resource('/blog', '\App\Http\Controllers\Back\BlogController');
    Route::post('/blog/remove_img', [BackBlogController::class, 'removeFeaturedImage']);
    Route::get('/blog_comments', [BackBlogController::class, 'comments']);
    Route::post('/blog_comments', [BackBlogController::class, 'deleteComment']);
    Route::resource('/blog_categories', '\App\Http\Controllers\Back\BlogCategoriesController');
    Route::get('/productSellStatus', [ProductController::class, 'productSellStatus'])->name('product.sell.status');
    Route::resource('/products', '\App\Http\Controllers\Back\ProductController');
    Route::get('/videos/add/', [BackVideoController::class, 'add_video']);
    Route::get('/videos/edit/{id}', [BackVideoController::class, 'edit_video']);
    Route::post('/videos/edit', [BackVideoController::class, 'post_edit_video']);
    Route::post('/videos/add', [BackVideoController::class, 'post_add_video']);
    Route::resource('/videos', '\App\Http\Controllers\Back\VideoController');
    // Gallery
    Route::resource('/gallery', '\App\Http\Controllers\Back\GalleryController');
    Route::post('/gallery/activate', [BackGalleryController::class, 'activate'])->name('album.activate');
    Route::post('/gallery/is_feature', [BackGalleryController::class, 'isfeatured'])->name('album.feature');
    Route::get('/albums/order', [BackGalleryController::class, 'order']);
    Route::get('/albums/gallery/order', [BackGalleryController::class, 'imagesOrder']);
    Route::post('/albums/gallery/status', [BackGalleryController::class, 'imageStatus']);
    Route::post('/albums/gallery/is_feature', [BackGalleryController::class, 'imageIsFeatured']);
    Route::get('/albums/gallery/delete/{id}', [BackGalleryController::class, 'deleteImage']);
    Route::get('/albums/{id}/gallery/create', [BackGalleryController::class, 'create'])->name('album.gallery.create');
    Route::post('/gallery/add_album', [BackGalleryController::class, 'add_album']);
    Route::post('/gallery/update_album', [BackGalleryController::class, 'update_album']);
    Route::post('/gallery/upload_album_images', [BackGalleryController::class, 'upload_album_images'])->name('upload_album_images');
    Route::get('/gallery/delete_album/{id}', [BackGalleryController::class, 'delete_album']);
    Route::post('/save_gallery_image_crop_image', [BackGalleryController::class, 'ajax_crop_gallery_img']);
    Route::post('/albums/gallery/markBeforeAfter', 'GalleryController@markBeforeAfter');
    Route::post('/getGalleryImageAltTitle', 'GalleryController@getGalleryImageAltTitle');
    Route::post('/saveGalleryImageAltTitle', 'GalleryController@saveGalleryImageAltTitle');
    // Gallery End
    Route::get('/gallery4444/ordering-set/', 'GalleryController@saveOrdering')->name('set999_ordering_gallery');
    Route::resource('/media', '\App\Http\Controllers\Back\MediaController');
    Route::post('/media/add_album', [MediaController::class, 'add_album']);
    Route::post('/media/update_album', [MediaController::class, 'update_album']);
    Route::post('/media/upload_album_images', [MediaController::class, 'upload_album_images'])->name('upload_media_images');
    Route::post('/media/delete_album/{id}', [MediaController::class, 'delete_album']);
    Route::resource('/files', '\App\Http\Controllers\Back\FilesController');
    Route::post('/files/add_album', [FilesController::class, 'add_album']);
    Route::post('/files/update_album', [FilesController::class, 'update_album']);
    Route::post('/files/upload_album_images', [FilesController::class, 'upload_album_images'])->name('upload_files_images');
    Route::post('/files/delete_album/{id}', [FilesController::class, 'delete_album']);
    Route::resource('/widgets', '\App\Http\Controllers\Back\WidgetController');
    Route::post('/widgets/update/{id}', [WidgetController::class, 'update'])->name('widget.update');
    Route::get('widgets/option/{id}', [WidgetController::class, 'option'])->name('widget.option');
    Route::post('widgets/option/update/{id}', [WidgetController::class, 'optionUpdate'])->name('widget.option.update');
    Route::get('removeWidgetImage/{id}', [WidgetController::class, 'removeFeaturedImage']);
    Route::resource('/social_media', '\App\Http\Controllers\Back\SocialMediaController');
    Route::resource('/user/admin', '\App\Http\Controllers\Back\AdminUserController');
    Route::resource('/user/admin_log', '\App\Http\Controllers\Back\AdminLogController');
    Route::resource('/user/front', '\App\Http\Controllers\Back\FrontUserController');
    Route::resource('/categories', '\App\Http\Controllers\Back\CategoriesController');
    Route::get('/cache', [CacheController::class, 'index'])->name('cache');
    Route::post('/cache', [CacheController::class, 'update']);
    Route::resource('/settings', '\App\Http\Controllers\Back\SettingController');
    Route::post('/setting/meta_data', [SettingController::class, 'updateMetaData']);
    Route::post('/setting/captcha', [SettingController::class, 'saveCaptcha']);
    Route::post('/setting/paypal', [SettingController::class, 'savePaypal']);
    Route::post('/setting/ip-address', [SettingController::class, 'ipAddress']);
    Route::post('/setting/js', [SettingController::class, 'js']);
    Route::post('/setting/admin_logo_favicon', [SettingController::class, 'adminLogoFavicon']);
    Route::get('/setting/countries', [SettingController::class, 'countries']);
    Route::resource('/file_manager', '\App\Http\Controllers\Back\FileManagerController');
    Route::get('/news_update', [DashboardController::class, 'updateNewsStatus']);
    Route::get('/news_page', [DashboardController::class, 'newsPage']);
    Route::get('/clear-cache', [DashboardController::class, 'clearCache']);
    Route::get('/leftsidebar/session', [DashboardController::class, 'sideBarLeft']);
    Route::get('/search', [SearchController::class, 'search']);
    Route::get('/site-map', [SiteMapController::class, 'siteMap']);
    Route::resource('/manage-theme', '\App\Http\Controllers\Back\ThemeController');
    Route::post('/manage-theme/update', [ThemeController::class, 'save']);
    /*DCODE HERE*/
    //package qustion start
    Route::resource('/question', 'PackageQuestionController');
    Route::get('/addView', 'PackageQuestionController@addView')->name('question.addView');
    Route::post('/question-update/{id}', 'PackageQuestionController@update')->name('question_update');
    //package question end
    //assesment qustion start
    Route::resource('/assesment_question', 'AssesmentQuestionController');
    Route::get('/assesment-addView', 'AssesmentQuestionController@addView')->name('assesment_question.addView');
    Route::get('/delete-assesment-question/{id}', 'AssesmentQuestionController@destroy')->name('delete_assesment_question');
    Route::post('/assesment-update/{id}', 'AssesmentQuestionController@update')->name('assesment_update');
    Route::post('/assesment-receipts-email', 'AssesmentQuestionController@update_receipts_assessment_question')->name('assesment_update_receipts_email');
    //assesment question end
    //package content start
    Route::get('/package-content/{id}', 'PackageContentController@index')->name('package_content_index');
    Route::post('/package-content-store', 'PackageContentController@store')->name('package_content_store');
    Route::get('/package-content-delete/{id}', 'PackageContentController@delete')->name('package_content_delete');
    Route::post('/package-content-edit-store', 'PackageContentController@editStoreContent')->name('package_content_store_edit');
    Route::get('/contact_request/convert_client/{id}', 'ContactUsController@convert_client')->name('lead_convert_client');
    Route::get('/send-assesment-email', 'ContactUsController@send_assesments_email')->name('send_assesment_email');
    //Contact us leads
    Route::resource('/contact_request', 'ContactUsController');
    Route::get('/get_contact_request_to_edit/{id}', [BackContactUsController::class, 'getContactRequestToEdit'])->name('get_contact_request_to_edit');
    Route::post('/update_contact_request', [BackContactUsController::class, 'updateContactRequest'])->name('update_contact_request');
    Route::post('/contact_request/lead_comment', 'ContactUsController@CommentContactLeads')->name('lead_comments');
    Route::get('/read_data_contact_lead/{id}', 'ContactUsController@contactUsReadData')->name('contact_lead_read');
    Route::get('/package-change-contact-lead', 'ContactUsController@packageChangeLeads')->name('package-change-contact-lead');
    Route::post('/contact_request/price', 'ContactUsController@PriceContactLeads')->name('lead_price');
    Route::post('/manage_clients/status', 'ClientController@status');
    Route::post('/manage_clients/update_condition', 'ClientController@update_condition');
    Route::resource('/manage_clients', 'ClientController');
    Route::post('/client_comments/request_comment', 'ClientController@CommentContactClients')->name('client_comments');
    Route::post('/clients-update-record/{id}', 'ClientController@update')->name('client_update_record_store');
    Route::get('/client_email_template/{id}', 'ClientController@ClientEmailTemplate')->name('client_email_templates');
    Route::post('/client-delete', 'ClientController@clientDelete')->name('client.delete');
    //sms send start
    Route::get('/client_sms_template/{id}', 'ClientController@ClientSMSTemplate')->name('client_sms_templates');
    Route::post('/send_sms_template_client', 'ClientController@sendSMSClient')->name('send_sms_template_client');
    //sms send end
    Route::post('/send_email_template_client', 'ClientController@sendEmailClient')->name('send_email_template_client');
    Route::get('/manage-client/package-status', 'ClientController@changePackageStatus')->name('manage_client_change_package_status');
    Route::get('/manage-client-packages/{id}', 'ClientController@ManageClientPackages')->name('manage_client_packages');
    Route::get('/manage-client-add-new-package/{id}', 'ClientController@clientAddPackageView')->name('manage_client_add_new_packages');
    Route::get('/get-package-prequalified-questions/{package_id}', 'ClientController@getPackagePrequalifiedQuestions')->name('get_client_prequalified_questions');
    Route::post('/client-package-store', 'ClientController@clientPackageStore')->name('client-package-store');
    //Email Templates
    Route::post('/email_templates/update_email_r', 'Email_templatesController@update_email_r');
    Route::post('/email_templates/add_status', 'Email_templatesController@add_status');
    Route::get('/email_templates/set_order', 'Email_templatesController@set_order');
    Route::get('/email_templates/pop', 'Email_templatesController@pop');
    Route::get('/email_templates/unset_search', 'Email_templatesController@unset_search');
    Route::post('/email_templates/update_status_tempaltes', 'Email_templatesController@update_status')->name('email_template_update_status_templates');
    Route::post('/email_templates/update_order', 'Email_templatesController@update_order');
    Route::resource('/email_templates', 'Email_templatesController');
    Route::post('/email_templates/delete_record', 'Email_templatesController@destroy')->name('email_template_delete_record');
    Route::post('/email_templates/update/{id}', 'Email_templatesController@update')->name('email_template_update_save');
    Route::resource('/message', 'MessageController');
    Route::post('custom_msg_store', 'MessageController@custom_msg_store')->name('custom_msg_store');
    Route::post('custom_msg_update/{id}', 'MessageController@custom_msg_update')->name('custom_msg_update');
    Route::get('/news', 'NewsController@index')->name('news.index');
    Route::get('/news/create', 'NewsController@create')->name('news.create');
    Route::post('/news', 'NewsController@store')->name('news.store');
    Route::get('/news/{newsObj}/edit', 'NewsController@edit')->name('news.edit');
    Route::put('/news/{newsObj}', 'NewsController@update')->name('news.update');
    Route::get('/news/{newsObj}', 'NewsController@show')->name('news.show');
    Route::delete('/news/{newsObj}', 'NewsController@destroy')->name('news.destroy');
    Route::get('fetchNewsAjax', 'NewsController@fetchNewsAjax')->name('fetchNewsAjax');
    Route::post('updateNewsStatus', 'NewsController@updateNewsStatus')->name('updateNewsStatus');
    Route::get('news-sort', 'NewsController@sortNews')->name('news.sort');
    Route::get('news-sort-data', 'NewsController@newsSortData')->name('news.sort.data');
    Route::put('news-sort-update', 'NewsController@newsSortUpdate')->name('news.sort.update');
    /* States Routes */
    Route::get('/states', 'StateController@index')->name('states.index');
    Route::get('/states/create', 'StateController@create')->name('states.create');
    Route::post('/states', 'StateController@store')->name('states.store');
    Route::get('/states/{stateObj}', 'StateController@show')->name('states.show');
    Route::get('/states/{stateObj}/edit', 'StateController@edit')->name('states.edit');
    Route::put('/states/{stateObj}', 'StateController@update')->name('states.update');
    Route::delete('/states/{stateObj}', 'StateController@destroy')->name('states.destroy');
    Route::get('fetchStatesAjax', 'StateController@fetchStatesAjax')->name('fetchStatesAjax');
    Route::post('updateStateStatus', 'StateController@updateStateStatus')->name('updateStateStatus');
    Route::get('states-sort', 'StateController@sortStates')->name('states.sort');
    Route::get('states-sort-data', 'StateController@statesSortData')->name('states.sort.data');
    Route::put('states-sort-update', 'StateController@statesSortUpdate')->name('states.sort.update');
    /* Counties Routes */
    Route::get('/counties', 'CountyController@index')->name('counties.index');
    Route::get('/counties/create', 'CountyController@create')->name('counties.create');
    Route::post('/counties', 'CountyController@store')->name('counties.store');
    Route::get('/counties/{countyObj}', 'CountyController@show')->name('counties.show');
    Route::get('/counties/{countyObj}/edit', 'CountyController@edit')->name('counties.edit');
    Route::put('/counties/{countyObj}', 'CountyController@update')->name('counties.update');
    Route::delete('/counties/{countyObj}', 'CountyController@destroy')->name('counties.destroy');
    Route::get('fetchCountiesAjax', 'CountyController@fetchCountiesAjax')->name('fetchCountiesAjax');
    Route::post('updateCountyStatus', 'CountyController@updateCountyStatus')->name('updateCountyStatus');
    Route::get('counties-sort', 'CountyController@sortCounties')->name('counties.sort');
    Route::get('counties-sort-data', 'CountyController@countiesSortData')->name('counties.sort.data');
    Route::put('counties-sort-update', 'CountyController@countiesSortUpdate')->name('counties.sort.update');
    /* Cities Routes */
    Route::get('/cities', 'CityController@index')->name('cities.index');
    Route::get('/cities/create', 'CityController@create')->name('cities.create');
    Route::post('/cities', 'CityController@store')->name('cities.store');
    Route::get('/cities/{cityObj}', 'CityController@show')->name('cities.show');
    Route::get('/cities/{cityObj}/edit', 'CityController@edit')->name('cities.edit');
    Route::put('/cities/{cityObj}', 'CityController@update')->name('cities.update');
    Route::delete('/cities/{cityObj}', 'CityController@destroy')->name('cities.destroy');
    Route::get('fetchCitiesAjax', 'CityController@fetchCitiesAjax')->name('fetchCitiesAjax');
    Route::post('updateCityStatus', 'CityController@updateCityStatus')->name('updateCityStatus');
    Route::get('cities-sort', 'CityController@sortCities')->name('cities.sort');
    Route::get('cities-sort-data', 'CityController@citiesSortData')->name('cities.sort.data');
    Route::put('cities-sort-update', 'CityController@citiesSortUpdate')->name('cities.sort.update');
    Route::post('citiesSortUpdateAjax', 'CityController@citiesSortUpdateAjax')->name('citiesSortUpdateAjax');
});

Route::group(['prefix' => 'adminmedia', 'middleware' => ['admin_auth', 'ipmiddleware']], function () {
    /* Banner Popups Routes */
    Route::get('/banner-popups', BannerPopupsList::class);
});


Route::view('permission_denied', 'front.home.permission_denied');
Route::get('/maintenance', 'Front\HomeController@maintenance');
Route::get('/block', 'Front\HomeController@block');
Route::post('searchZipCodeAjax', 'Front\AjaxController@searchZipCodeAjax')->name('searchZipCodeAjax');
Route::post('filterCountiesAjax', 'Front\AjaxController@filterCountiesAjax')->name('filterCountiesAjax');
Route::post('filterCitiesAjax', 'Front\AjaxController@filterCitiesAjax')->name('filterCitiesAjax');
Route::get('/clear-cache', function () {
    Cache::flush();
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    /*************************** */
    return 'Cache is cleared';
});
Route::group(['namespace' => 'Front', 'middleware' => ['siteStatus', 'clearCache', 'ipmiddleware']], function () {
    Route::get('/{slug}', [HomeController::class, 'page']);
});
