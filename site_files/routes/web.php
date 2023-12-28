<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Front\AjaxController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\Front\GalleryController;
use App\Http\Controllers\Front\InvoiceController;
use App\Http\Controllers\Back\FrontUserController;
use App\Http\Controllers\Front\ServicesController;
use App\Http\Controllers\Front\ContactUsController;
use App\Http\Controllers\Front\MailChimpController;
use App\Http\Controllers\Front\TestimonialController;
use App\Http\Controllers\Front\ClientRegisterController;
use App\Http\Controllers\Back\BlogController as BackBlogController;
use App\Http\Controllers\Back\CityController as BackCityController;
use App\Http\Controllers\Back\MenuController as BackMenuController;
use App\Http\Controllers\Back\NewsController as BackNewsController;
use App\Http\Controllers\HomeController as UserDashboardController;
use App\Http\Controllers\Back\CacheController as BackCacheController;
use App\Http\Controllers\Back\FilesController as BackFilesController;
use App\Http\Controllers\Back\MediaController as BackMediaController;
use App\Http\Controllers\Back\StateController as BackStateController;
use App\Http\Controllers\Back\ThemeController as BackThemeController;
use App\Http\Controllers\Back\VideoController as BackVideoController;
use App\Http\Controllers\Back\CareerController as BackCareerController;
use App\Http\Controllers\Back\ClientController as BackClientController;
use App\Http\Controllers\Back\CountyController as BackCountyController;
use App\Http\Controllers\Back\ModuleController as BackModuleController;
use App\Http\Controllers\Back\SearchController as BackSearchController;
use App\Http\Controllers\Back\WidgetController as BackWidgetController;
use App\Http\Controllers\Back\GalleryController as BackGalleryController;
use App\Http\Controllers\Back\InvoiceController as BackInvoiceController;
use App\Http\Controllers\Back\MessageController as BackMessageController;
use App\Http\Controllers\Back\ProductController as BackProductController;
use App\Http\Controllers\Back\SettingController as BackSettingController;
use App\Http\Controllers\Back\SiteMapController as BackSiteMapController;
use App\Http\Controllers\Back\AdminLogController as BackAdminLogController;
use App\Http\Controllers\Back\ContactFormSetting as BackContactFormSetting;
use App\Livewire\Back\BannerPopups\BannerPopupsList as BackBannerPopupsList;
use App\Livewire\Back\BannerPopups\SortBannerPopups as BackSortBannerPopups;
use App\Http\Controllers\Back\AdminUserController as BackAdminUserController;
use App\Http\Controllers\Back\ContactUsController as BackContactUsController;
use App\Http\Controllers\Back\DashboardController as BackDashboardController;
use App\Http\Controllers\AdminAuth\LoginController as AdminAuthLoginController;
use App\Http\Controllers\Back\CategoriesController as BackCategoriesController;
use App\Http\Controllers\Back\FileManagerController as BackFileManagerController;
use App\Http\Controllers\Back\ImageUploadController as BackImageUploadController;
use App\Http\Controllers\Back\SocialMediaController as BackSocialMediaController;
use App\Http\Controllers\Back\ContactPagesController as BackContactPagesController;
use App\Http\Controllers\Back\ModuleManageController as BackModuleManageController;
use App\Http\Controllers\Back\PaymentOptionController as BackPaymentOptionController;
use App\Http\Controllers\Back\BlogCategoriesController as BackBlogCategoriesController;
use App\Http\Controllers\Back\JobApplicationController as BackJobApplicationController;
use App\Http\Controllers\Back\PackageContentController as BackPackageContentController;
use App\Http\Controllers\Back\Email_templatesController as BackEmail_templatesController;
use App\Http\Controllers\Back\PackageQuestionController as BackPackageQuestionController;
use App\Http\Controllers\AdminAuth\VerificationController as AdminAuthVerificationController;
use App\Http\Controllers\Back\AssesmentQuestionController as BackAssesmentQuestionController;
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

/************************************* */
/************************************* */
/***********  ADMINMEDIA ************* */
/************************************* */
/************************************* */
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
/*********************************** */
Route::group(['prefix' => 'adminmedia', 'middleware' => ['admin_auth', 'ipmiddleware']], function () {
    Route::get('/', [BackDashboardController::class, 'index']);
    Route::get('/aaa', function () {
        return view('back.common_views.script');
    });
    Route::get('/run_script', [BackModuleManageController::class, 'run_script']);
    Route::get('/jobCommonContact', [BackModuleManageController::class, 'contact_single_job']);
    Route::post('/jobCommonContactSave', [BackModuleManageController::class, 'commonContactSave'])->name('job.common.contact.save');
    Route::resource('/modules', BackModuleController::class);
    Route::get('/module/ordering/{type}', [BackModuleManageController::class, 'showOrderPage']);
    Route::get('/module/ordering-set/{type}', [BackModuleManageController::class, 'saveOrdering']);
    Route::resource('/module/{type}/', BackModuleManageController::class);
    Route::get('/module/{type}/add', [BackModuleManageController::class, 'add_single_module']);
    Route::get('/module/{type}/edit/{id}', [BackModuleManageController::class, 'edit_single_module']);
    Route::get('/module/{type}/{id}/edit', [BackModuleManageController::class, 'edit']);
    Route::post('/module/{type}/{id}/', [BackModuleManageController::class, 'update']);
    Route::delete('/module/delete/{id}/', [BackModuleManageController::class, 'destroy']);
    Route::get('/modul/remove_image', [BackModuleManageController::class, 'removeFeaturedImage']);
    Route::post('/modul/crop_image', [BackModuleManageController::class, 'ajax_crop_img']);
    Route::post('/module_image/upload_image', [BackImageUploadController::class, 'store']);
    Route::post('uploadTinyMceImage', [BackImageUploadController::class, 'uploadTinyMceImage'])->name('uploadTinyMceImage');
    Route::post('/module_image/remove_image', [BackImageUploadController::class, 'removeUploadedImage']);
    Route::post('/module_image/upload_more_images', [BackImageUploadController::class, 'uploadMoreImages']);
    Route::post('/save_module_data_image_crop_image', [BackModuleManageController::class, 'ajax_crop_module_data_img']);
    Route::post('/getModuleDataImageAltTitle', [BackModuleManageController::class, 'getModuleDataImageAltTitle']);
    Route::post('/saveModuleDataImageAltTitle', [BackModuleManageController::class, 'saveModuleDataImageAltTitle']);
    Route::post('/modules/updatePageOptions', [BackModuleController::class, 'updatePageOptions']);
    Route::post('/payment_options/paypal_email', [BackPaymentOptionController::class, 'paypal_email']);
    Route::post('/payment_options/authorize_net', [BackPaymentOptionController::class, 'authorize_net']);
    Route::post('/payment_options/status', [BackPaymentOptionController::class, 'status']);
    Route::resource('/payment_options', BackPaymentOptionController::class);
    Route::post('/invoice/status', [BackInvoiceController::class, 'status']);
    Route::get('/invoice/invoice_test', [BackInvoiceController::class, 'demo_invoice']);
    Route::get('/invoice/send_invoice', [BackInvoiceController::class, 'create_invoice']);
    Route::post('/invoice/post_send_invoice', [BackInvoiceController::class, 'post']);
    Route::post('/invoice/re_send_invoice', [BackInvoiceController::class, 're_send_invoice']);
    Route::resource('/invoice', BackInvoiceController::class);
    Route::resource('/menus', BackMenuController::class);
    Route::resource('/contact_request', BackContactUsController::class);
    Route::get('/contact_request/convert_client/{id}', [BackContactUsController::class, 'convert_client'])->name('lead_convert_client');
    //Contact us leads
    Route::get('/contact_request/export/{exportType}', [BackContactUsController::class, 'exportLeads'])->name('export.leads');
    Route::post('/contact_request/lead_comment', [BackContactUsController::class, 'CommentContactLeads'])->name('lead_comments');
    Route::get('/read_data_contact_lead/{id}', [BackContactUsController::class, 'contactUsReadData'])->name('contact_lead_read');
    Route::post('/contact-request-bulk-actions', [BackContactUsController::class, 'contactUsBulkActions'])->name('contact_request.bulk.actions');
    Route::post('/contact_request/price', [BackContactUsController::class, 'PriceContactLeads'])->name('lead_price');
    Route::get('/get_contact_request_to_edit/{id}', [BackContactUsController::class, 'getContactRequestToEdit'])->name('get_contact_request_to_edit');
    Route::post('/update_contact_request', [BackContactUsController::class, 'updateContactRequest'])->name('update_contact_request');
    Route::post('/manage_clients/status', [BackClientController::class, 'status']);
    Route::resource('/manage_clients', BackClientController::class);
    Route::post('/client_comments/request_comment', [BackClientController::class, 'CommentContactClients'])->name('client_comments');
    Route::resource('/manage_contact', BackContactPagesController::class);
    Route::resource('/contact_form_settings', BackContactFormSetting::class);
    Route::post('/contact_form_settings/spam', [BackContactFormSetting::class, 'update_spam_words']);
    Route::post('/manage_contacts/emails', [BackContactPagesController::class, 'emailUpdate']);
    Route::post('/manage_contacts/email_delete', [BackContactPagesController::class, 'emailDelete']);
    Route::resource('/blog', BackBlogController::class);
    Route::post('/blog/remove_img', [BackBlogController::class, 'removeFeaturedImage']);
    Route::get('/blog_comments', [BackBlogController::class, 'comments']);
    Route::post('/blog_comments', [BackBlogController::class, 'deleteComment']);
    Route::resource('/blog_categories', BackBlogCategoriesController::class);
    Route::get('/productSellStatus', [BackProductController::class, 'productSellStatus'])->name('product.sell.status');
    Route::resource('/products', BackProductController::class);
    Route::get('/videos/add/', [BackVideoController::class, 'add_video']);
    Route::get('/videos/edit/{id}', [BackVideoController::class, 'edit_video']);
    Route::post('/videos/edit', [BackVideoController::class, 'post_edit_video']);
    Route::post('/videos/add', [BackVideoController::class, 'post_add_video']);
    Route::get('/videos/ordering-set/', [BackVideoController::class, 'saveOrdering']);
    Route::resource('/videos', BackVideoController::class);
    // Gallery
    Route::resource('/gallery', BackGalleryController::class);
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
    Route::post('/albums/gallery/markBeforeAfter', [BackGalleryController::class, 'markBeforeAfter']);
    Route::post('/getGalleryImageAltTitle', [BackGalleryController::class, 'getGalleryImageAltTitle']);
    Route::post('/saveGalleryImageAltTitle', [BackGalleryController::class, 'saveGalleryImageAltTitle']);
    // Gallery End
    Route::get('/gallery4444/ordering-set/', [BackGalleryController::class, 'saveOrdering'])->name('set999_ordering_gallery');
    Route::resource('/media', BackMediaController::class);
    Route::post('/media/add_album', [BackMediaController::class, 'add_album']);
    Route::post('/media/update_album', [BackMediaController::class, 'update_album']);
    Route::post('/media/upload_album_images', [BackMediaController::class, 'upload_album_images'])->name('upload_media_images');
    Route::post('/media/delete_album/{id}', [BackMediaController::class, 'delete_album']);
    Route::resource('/files', BackFilesController::class);
    Route::post('/files/add_album', [BackFilesController::class, 'add_album']);
    Route::post('/files/update_album', [BackFilesController::class, 'update_album']);
    Route::post('/files/upload_album_images', [BackFilesController::class, 'upload_album_images'])->name('upload_files_images');
    Route::post('/files/delete_album/{id}', [BackFilesController::class, 'delete_album']);
    Route::resource('/widgets', BackWidgetController::class);
    Route::post('/widgets/update/{id}', [BackWidgetController::class, 'update'])->name('widget.update');
    Route::get('widgets/option/{id}', [BackWidgetController::class, 'option'])->name('widget.option');
    Route::post('widgets/option/update/{id}', [BackWidgetController::class, 'optionUpdate'])->name('widget.option.update');
    Route::get('removeWidgetImage/{id}', [BackWidgetController::class, 'removeFeaturedImage']);
    Route::resource('/social_media', BackSocialMediaController::class);
    Route::resource('/user/admin', BackAdminUserController::class);
    Route::resource('/user/admin_log', BackAdminLogController::class);
    Route::resource('/user/front', FrontUserController::class);
    Route::resource('/categories', BackCategoriesController::class);
    Route::get('/cache', [BackCacheController::class, 'index'])->name('cache');
    Route::post('/cache', [BackCacheController::class, 'update']);
    Route::resource('/settings', BackSettingController::class);
    Route::post('/setting/meta_data', [BackSettingController::class, 'updateMetaData']);
    Route::post('/setting/captcha', [BackSettingController::class, 'saveCaptcha']);
    Route::post('/setting/paypal', [BackSettingController::class, 'savePaypal']);
    Route::post('/setting/ip-address', [BackSettingController::class, 'ipAddress']);
    Route::post('/setting/js', [BackSettingController::class, 'js']);
    Route::post('/setting/admin_logo_favicon', [BackSettingController::class, 'adminLogoFavicon']);
    Route::get('/setting/countries', [BackSettingController::class, 'countries']);
    Route::resource('/file_manager', BackFileManagerController::class);
    Route::get('/news_update', [BackDashboardController::class, 'updateNewsStatus']);
    Route::get('/news_page', [BackDashboardController::class, 'newsPage']);
    Route::get('/clear-cache', [BackDashboardController::class, 'clearCache']);
    Route::get('/leftsidebar/session', [BackDashboardController::class, 'sideBarLeft']);
    Route::get('/search', [BackSearchController::class, 'search']);
    Route::get('/site-map', [BackSiteMapController::class, 'siteMap']);
    Route::resource('/manage-theme', BackThemeController::class);
    Route::post('/manage-theme/update', [BackThemeController::class, 'save']);
    //package qustion start
    Route::resource('/question', BackPackageQuestionController::class);
    Route::get('/addView', [BackPackageQuestionController::class, 'addView'])->name('question.addView');
    Route::post('/question-update/{id}', [BackPackageQuestionController::class, 'update'])->name('question_update');
    //package question end
    //assesment qustion start
    Route::resource('/assesment_question', BackAssesmentQuestionController::class);
    Route::get('/assesment-addView', [BackAssesmentQuestionController::class, 'addView'])->name('assesment_question.addView');
    Route::get('/delete-assesment-question/{id}', [BackAssesmentQuestionController::class, 'destroy'])->name('delete_assesment_question');
    Route::post('/assesment-update/{id}', [BackAssesmentQuestionController::class, 'update'])->name('assesment_update');
    Route::post('/assesment-receipts-email', [BackAssesmentQuestionController::class, 'update_receipts_assessment_question'])->name('assesment_update_receipts_email');
    //assesment question end
    //package content start
    Route::get('/package-content/{id}', [BackPackageContentController::class, 'index'])->name('package_content_index');
    Route::post('/package-content-store', [BackPackageContentController::class, 'store'])->name('package_content_store');
    Route::get('/package-content-delete/{id}', [BackPackageContentController::class, 'delete'])->name('package_content_delete');
    Route::post('/package-content-edit-store', [BackPackageContentController::class, 'editStoreContent'])->name('package_content_store_edit');
    Route::get('/contact_request/convert_client/{id}', [BackContactUsController::class, 'convert_client'])->name('lead_convert_client');
    Route::get('/send-assesment-email', [BackContactUsController::class, 'send_assesments_email'])->name('send_assesment_email');
    //Contact us leads
    Route::resource('/contact_request', BackContactUsController::class);
    Route::get('/get_contact_request_to_edit/{id}', [BackContactUsController::class, 'getContactRequestToEdit'])->name('get_contact_request_to_edit');
    Route::post('/update_contact_request', [BackContactUsController::class, 'updateContactRequest'])->name('update_contact_request');
    Route::post('/contact_request/lead_comment', [BackContactUsController::class, 'CommentContactLeads'])->name('lead_comments');
    Route::get('/read_data_contact_lead/{id}', [BackContactUsController::class, 'contactUsReadData'])->name('contact_lead_read');
    Route::get('/package-change-contact-lead', [BackContactUsController::class, 'packageChangeLeads'])->name('package-change-contact-lead');
    Route::post('/contact_request/price', [BackContactUsController::class, 'PriceContactLeads'])->name('lead_price');
    Route::post('/manage_clients/status', [BackClientController::class, 'status']);
    Route::post('/manage_clients/update_condition', [BackClientController::class, 'update_condition']);
    Route::resource('/manage_clients', BackClientController::class);
    Route::post('/client_comments/request_comment', [BackClientController::class, 'CommentContactClients'])->name('client_comments');
    Route::post('/clients-update-record/{id}', [BackClientController::class, 'update'])->name('client_update_record_store');
    Route::get('/client_email_template/{id}', [BackClientController::class, 'ClientEmailTemplate'])->name('client_email_templates');
    Route::post('/client-delete', [BackClientController::class, 'clientDelete'])->name('client.delete');
    //sms send start
    Route::get('/client_sms_template/{id}', [BackClientController::class, 'ClientSMSTemplate'])->name('client_sms_templates');
    Route::post('/send_sms_template_client', [BackClientController::class, 'sendSMSClient'])->name('send_sms_template_client');
    //sms send end
    Route::post('/send_email_template_client', [BackClientController::class, 'sendEmailClient'])->name('send_email_template_client');
    Route::get('/manage-client/package-status', [BackClientController::class, 'changePackageStatus'])->name('manage_client_change_package_status');
    Route::get('/manage-client-packages/{id}', [BackClientController::class, 'ManageClientPackages'])->name('manage_client_packages');
    Route::get('/manage-client-add-new-package/{id}', [BackClientController::class, 'clientAddPackageView'])->name('manage_client_add_new_packages');
    Route::get('/get-package-prequalified-questions/{package_id}', [BackClientController::class, 'getPackagePrequalifiedQuestions'])->name('get_client_prequalified_questions');
    Route::post('/client-package-store', [BackClientController::class, 'clientPackageStore'])->name('client-package-store');
    //Email Templates
    Route::post('/email_templates/update_email_r', [BackEmail_templatesController::class, 'update_email_r']);
    Route::post('/email_templates/add_status', [BackEmail_templatesController::class, 'add_status']);
    Route::get('/email_templates/set_order', [BackEmail_templatesController::class, 'set_order']);
    Route::get('/email_templates/pop', [BackEmail_templatesController::class, 'pop']);
    Route::get('/email_templates/unset_search', [BackEmail_templatesController::class, 'unset_search']);
    Route::post('/email_templates/update_status_tempaltes', [BackEmail_templatesController::class, 'update_status'])->name('email_template_update_status_templates');
    Route::post('/email_templates/update_order', [BackEmail_templatesController::class, 'update_order']);
    Route::resource('/email_templates', BackEmail_templatesController::class);
    Route::post('/email_templates/delete_record', [BackEmail_templatesController::class, 'destroy'])->name('email_template_delete_record');
    Route::post('/email_templates/update/{id}', [BackEmail_templatesController::class, 'update'])->name('email_template_update_save');
    Route::resource('/message', BackMessageController::class);
    Route::post('custom_msg_store', [BackMessageController::class, 'custom_msg_store'])->name('custom_msg_store');
    Route::post('custom_msg_update/{id}', [BackMessageController::class, 'custom_msg_update'])->name('custom_msg_update');
    Route::get('/news', [BackNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [BackNewsController::class, 'create'])->name('news.create');
    Route::post('/news', [BackNewsController::class, 'store'])->name('news.store');
    Route::get('/news/{newsObj}/edit', [BackNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{newsObj}', [BackNewsController::class, 'update'])->name('news.update');
    Route::get('/news/{newsObj}', [BackNewsController::class, 'show'])->name('news.show');
    Route::delete('/news/{newsObj}', [BackNewsController::class, 'destroy'])->name('news.destroy');
    Route::get('fetchNewsAjax', [BackNewsController::class, 'fetchNewsAjax'])->name('fetchNewsAjax');
    Route::post('updateNewsStatus', [BackNewsController::class, 'updateNewsStatus'])->name('updateNewsStatus');
    Route::get('news-sort', [BackNewsController::class, 'sortNews'])->name('news.sort');
    Route::get('news-sort-data', [BackNewsController::class, 'newsSortData'])->name('news.sort.data');
    Route::put('news-sort-update', [BackNewsController::class, 'newsSortUpdate'])->name('news.sort.update');
    /* States Routes */
    Route::get('/states', [BackStateController::class, 'index'])->name('states.index');
    Route::get('/states/create', [BackStateController::class, 'create'])->name('states.create');
    Route::post('/states', [BackStateController::class, 'store'])->name('states.store');
    Route::get('/states/{stateObj}', [BackStateController::class, 'show'])->name('states.show');
    Route::get('/states/{stateObj}/edit', [BackStateController::class, 'edit'])->name('states.edit');
    Route::put('/states/{stateObj}', [BackStateController::class, 'update'])->name('states.update');
    Route::delete('/states/{stateObj}', [BackStateController::class, 'destroy'])->name('states.destroy');
    Route::get('fetchStatesAjax', [BackStateController::class, 'fetchStatesAjax'])->name('fetchStatesAjax');
    Route::post('updateStateStatus', [BackStateController::class, 'updateStateStatus'])->name('updateStateStatus');
    Route::get('states-sort', [BackStateController::class, 'sortStates'])->name('states.sort');
    Route::get('states-sort-data', [BackStateController::class, 'statesSortData'])->name('states.sort.data');
    Route::put('states-sort-update', [BackStateController::class, 'statesSortUpdate'])->name('states.sort.update');
    /* Counties Routes */
    Route::get('/counties', [BackCountyController::class, 'index'])->name('counties.index');
    Route::get('/counties/create', [BackCountyController::class, 'create'])->name('counties.create');
    Route::post('/counties', [BackCountyController::class, 'store'])->name('counties.store');
    Route::get('/counties/{countyObj}', [BackCountyController::class, 'show'])->name('counties.show');
    Route::get('/counties/{countyObj}/edit', [BackCountyController::class, 'edit'])->name('counties.edit');
    Route::put('/counties/{countyObj}', [BackCountyController::class, 'update'])->name('counties.update');
    Route::delete('/counties/{countyObj}', [BackCountyController::class, 'destroy'])->name('counties.destroy');
    Route::get('fetchCountiesAjax', [BackCountyController::class, 'fetchCountiesAjax'])->name('fetchCountiesAjax');
    Route::post('updateCountyStatus', [BackCountyController::class, 'updateCountyStatus'])->name('updateCountyStatus');
    Route::get('counties-sort', [BackCountyController::class, 'sortCounties'])->name('counties.sort');
    Route::get('counties-sort-data', [BackCountyController::class, 'countiesSortData'])->name('counties.sort.data');
    Route::put('counties-sort-update', [BackCountyController::class, 'countiesSortUpdate'])->name('counties.sort.update');
    /* Cities Routes */
    Route::get('/cities', [BackCityController::class, 'index'])->name('cities.index');
    Route::get('/cities/create', [BackCityController::class, 'create'])->name('cities.create');
    Route::post('/cities', [BackCityController::class, 'store'])->name('cities.store');
    Route::get('/cities/{cityObj}', [BackCityController::class, 'show'])->name('cities.show');
    Route::get('/cities/{cityObj}/edit', [BackCityController::class, 'edit'])->name('cities.edit');
    Route::put('/cities/{cityObj}', [BackCityController::class, 'update'])->name('cities.update');
    Route::delete('/cities/{cityObj}', [BackCityController::class, 'destroy'])->name('cities.destroy');
    Route::get('fetchCitiesAjax', [BackCityController::class, 'fetchCitiesAjax'])->name('fetchCitiesAjax');
    Route::post('updateCityStatus', [BackCityController::class, 'updateCityStatus'])->name('updateCityStatus');
    Route::get('cities-sort', [BackCityController::class, 'sortCities'])->name('cities.sort');
    Route::get('cities-sort-data', [BackCityController::class, 'citiesSortData'])->name('cities.sort.data');
    Route::put('cities-sort-update', [BackCityController::class, 'citiesSortUpdate'])->name('cities.sort.update');
    Route::post('citiesSortUpdateAjax', [BackCityController::class, 'citiesSortUpdateAjax'])->name('citiesSortUpdateAjax');
    //Career
    Route::get('/careers', [BackCareerController::class, 'index'])->name('careers.index');
    Route::get('/career/create', [BackCareerController::class, 'create'])->name('career.create');
    Route::post('/career', [BackCareerController::class, 'store'])->name('career.store');
    Route::get('/career/{careerObj}/edit', [BackCareerController::class, 'edit'])->name('career.edit');
    Route::put('/career/{careerObj}', [BackCareerController::class, 'update'])->name('career.update');
    Route::get('/career/{careerObj}', [BackCareerController::class, 'show'])->name('career.show');
    Route::delete('/career/{careerObj}', [BackCareerController::class, 'destroy'])->name('career.destroy');
    Route::get('fetchCareersAjax', [BackCareerController::class, 'fetchCareersAjax'])->name('fetchCareersAjax');
    Route::post('updateCareerStatus', [BackCareerController::class, 'updateCareerStatus'])->name('updateCareerStatus');
    Route::get('careers-sort', [BackCareerController::class, 'sortCareers'])->name('careers.sort');
    Route::get('careers-sort-data', [BackCareerController::class, 'careersSortData'])->name('careers.sort.data');
    Route::put('careers-sort-update', [BackCareerController::class, 'careersSortUpdate'])->name('careers.sort.update');
    //Job Applications
    Route::get('/job-applications', [BackJobApplicationController::class, 'index'])->name('job.applications.index');
    Route::get('/job-application/{jobApplicationObj}', [BackJobApplicationController::class, 'show'])->name('job.application.show');
    Route::delete('/job-application/{jobApplicationObj}', [BackJobApplicationController::class, 'destroy'])->name('job.application.destroy');
    Route::get('fetchJobApplicationsAjax', [BackJobApplicationController::class, 'fetchJobApplicationsAjax'])->name('fetchJobApplicationsAjax');
});
Route::group(['prefix' => 'adminmedia', 'middleware' => ['admin_auth', 'ipmiddleware']], function () {
    /* Banner Popups Routes */
    Route::get('/banner-popups', BackBannerPopupsList::class)->name('banner-popups-list');
    Route::get('/sort-banner-popups', BackSortBannerPopups::class)->name('sort-banner-popups');
});
/************************************* */
/************************************* */
/***********  Front ****************** */
/************************************* */
/************************************* */
Auth::routes();
Route::group(['middleware' => ['siteStatus', 'clearCache', 'ipmiddleware']], function () {
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
    Route::resource('/blog', BlogController::class);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{slug}', VideoController::class,'show');
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
    Route::get('/getState/{ads}', [ClientRegisterController::class, 'getState'])->name('get_state');
    Route::get('/getCity/{ads}', [ClientRegisterController::class, 'getCity'])->name('get_city');
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
/******************************* */
/******************************* */
Route::view('permission_denied', 'front.home.permission_denied');
Route::get('/maintenance', [HomeController::class, 'maintenance']);
Route::get('/block', [HomeController::class, 'block']);
Route::post('searchZipCodeAjax', [AjaxController::class, 'searchZipCodeAjax'])->name('searchZipCodeAjax');
Route::post('filterCountiesAjax', [AjaxController::class, 'filterCountiesAjax'])->name('filterCountiesAjax');
Route::post('filterCitiesAjax', [AjaxController::class, 'filterCitiesAjax'])->name('filterCitiesAjax');
Route::get('/clear-cache', function () {
    Cache::flush();
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    /*************************** */
    $directory = config('session.files');
    $ignoreFiles = ['.gitignore', '.', '..'];
    $files = scandir($directory);
    foreach ($files as $file) {
        if (!in_array($file, $ignoreFiles)) {
            unlink($directory . '/' . $file);
        }
    }
    /*************************** */
    $directory = config('logfile.files');
    $ignoreFiles = ['.gitignore', '.', '..'];
    $files = scandir($directory);
    foreach ($files as $file) {
        if (!in_array($file, $ignoreFiles)) {
            unlink($directory . '/' . $file);
        }
    }
    /*************************** */
    return 'Cache is cleared';
});
Route::group(['middleware' => ['siteStatus', 'clearCache', 'ipmiddleware']], function () {
    Route::get('/{slug}', [HomeController::class, 'page']);
});
/************************************* */
/************************************* */
/***********  Member ***************** */
/************************************* */
/************************************* */
Route::group(['prefix' => 'member', 'name' => 'member', 'middleware' => ['auth', 'ipmiddleware']], function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
});
