<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\Auth\StudentLoginController;
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


require __DIR__.'/auth.php';

/*STUDENT AUTH*/

//Login Routes
Route::get('{slug}/student-login','Student\Auth\StudentLoginController@showLoginForm')->name('student.loginform');
Route::post('{slug}/student-login/{cart?}','Student\Auth\StudentLoginController@login')->name('student.login');
Route::post('{slug}/student-logout','Student\Auth\StudentLoginController@logout')->name('student.logout');
//Forgot Password Routes
Route::get('{slug}/student-password/reset','Student\Auth\StudentForgotPasswordController@showLinkRequestForm')->name('student.password.request');
Route::post('{slug}/student-password/email','Student\Auth\StudentForgotPasswordController@postStudentEmail')->name('student.password.email');
/*Reset Password Routes*/
Route::get('{slug}/student-password/reset/{token}','Student\Auth\StudentForgotPasswordController@getStudentPassword')->name('student.password.reset');
Route::post('{slug}/student-password/reset','Student\Auth\StudentForgotPasswordController@updateStudentPassword')->name('student.password.update');
/*Profile*/
Route::get('{slug}/student-profile/{id}','Student\Auth\StudentLoginController@profile')->name('student.profile')->middleware('studentAuth');
Route::put('{slug}/student-profile/{id}','Student\Auth\StudentLoginController@profileUpdate')->name('student.profile.update')->middleware('studentAuth');
Route::put('{slug}/student-profile-password/{id}','Student\Auth\StudentLoginController@updatePassword')->name('student.profile.password')->middleware('studentAuth');

// Auth::routes();

// Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');

// Route::get('/password/resets/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');


Route::get(
    '/', [
           'as' => 'dashboard',
           'uses' => 'DashboardController@index',
       ]
)->middleware(
    [
        'XSS',
    ]
);
Route::get(
    '/dashboard', [
                    'as' => 'dashboard',
                    'uses' => 'DashboardController@index',
                ]
)->middleware(
    [
        'XSS',
        'auth',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
        ],
    ], function (){
    Route::resource('stores', 'StoreController');
    Route::post('store-setting/{id}', 'StoreController@savestoresetting')->name('settings.store');
}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::get('create-language', 'LanguageController@createLanguage')->name('create.language')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
    Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

    Route::delete('/lang/{lang}', 'LanguageController@destroyLang')->name('lang.destroy')->middleware(
        [
            'auth',
            'XSS',
        ]
    );
}
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::get('store-grid/grid', 'StoreController@grid')->name('store.grid');
    Route::get('store-customDomain/customDomain', 'StoreController@customDomain')->name('store.customDomain');
    Route::get('store-subDomain/subDomain', 'StoreController@subDomain')->name('store.subDomain');
    Route::DELETE('store-delete/{id}', 'StoreController@storedestroy')->name('user.destroy');
    Route::DELETE('ownerstore-delete/{id}', 'StoreController@ownerstoredestroy')->name('ownerstore.destroy');
    Route::get('store-edit/{id}', 'StoreController@storedit')->name('user.edit');;
    Route::Put('store-update/{id}', 'StoreController@storeupdate')->name('user.update');;
}
);

Route::get('/store-change/{id}', 'StoreController@changeCurrantStore')->name('change_store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/change/mode', [
                      'as' => 'change.mode',
                      'uses' => 'DashboardController@changeMode',
                  ]
);

Route::get('profile', 'DashboardController@profile')->name('profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put('change-password', 'DashboardController@updatePassword')->name('update.password');
Route::put('edit-profile', 'DashboardController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('storeanalytic', 'StoreAnalytic@index')->middleware('auth')->name('storeanalytic')->middleware(['XSS']);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function (){
    Route::post('business-setting', 'SettingController@saveBusinessSettings')->name('business.setting');
    Route::post('company-setting', 'SettingController@saveCompanySettings')->name('company.setting');
    Route::post('email-setting', 'SettingController@saveEmailSettings')->name('email.setting');
    Route::post('system-setting', 'SettingController@saveSystemSettings')->name('system.setting');
    Route::post('pusher-setting', 'SettingController@savePusherSettings')->name('pusher.setting');
    Route::get('test-mail', 'SettingController@testMail')->name('test.mail');
    Route::post('test-mail', 'SettingController@testSendMail')->name('test.send.mail');
    Route::get('settings', 'SettingController@index')->name('settings');
    Route::post('payment-setting', 'SettingController@savePaymentSettings')->name('payment.setting');
    Route::post('owner-payment-setting/{slug?}', 'SettingController@saveOwnerPaymentSettings')->name('owner.payment.setting');
    Route::post('owner-email-setting/{slug?}', 'SettingController@saveOwneremailSettings')->name('owner.email.setting');  
    
}
);

// certificate
Route::get(
    '/certificate/preview/{template}/{color}/{gradiant?}',[
                                              'as' => 'certificate.preview',
                                              'uses' => 'SettingController@previewCertificate',
                                            ]
);

Route::post(
    '/certificate/template/setting', [
                                    'as' => 'certificate.template.setting',
                                    'uses' => 'SettingController@saveCertificateSettings',
                                ]
);
//   ------------- //

Route::resource('product_categorie', 'ProductCategorieController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('product_tax', 'ProductTaxController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('shipping', 'ShippingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('location', 'LocationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('custom-page', 'PageOptionController')->middleware(['auth','XSS']);
Route::resource('blog', 'BlogController')->middleware(
    [
        'auth',
    ]
);
Route::get('blog-social', 'BlogController@socialBlog')->name('blog.social')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('store-social-blog', 'BlogController@storeSocialblog')->name('store.socialblog')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('shipping', 'ShippingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('orders', 'OrderController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('order-receipt/{id}', 'OrderController@receipt')->name('order.receipt')->middleware(
    [
        'auth',
    ]
);

Route::group(
    [
        'middleware' => [
            'XSS',
        ],
    ], function (){
    Route::resource('rating', 'RattingController');
    Route::post('rating_view', 'RattingController@rating_view')->name('rating.rating_view');
    Route::get('rating/{slug?}/product/{id}', 'RattingController@rating')->name('rating');
    Route::post('store_rating/{slug?}/product/{course_id}/{tutor_id}', 'RattingController@store_rating')->name('store_rating');
    Route::post('edit_rating/product/{id}', 'RattingController@edit_rating')->name('edit_rating');

}
);
Route::group(
    [
        'middleware' => [
            'XSS',
        ],
    ], function (){
    Route::resource('subscriptions', 'SubscriptionController');
    Route::POST('subscriptions/{id}', 'SubscriptionController@store_email')->name('subscriptions.store_email');
}
);
Route::group(
    [
        'middleware' => [
            'auth',
        ],
    ], function (){
    Route::get(
        '/product-variants/create', [
        'as' => 'product.variants.create',
        'uses' => 'ProductController@productVariantsCreate',
    ]
    );
    Route::get(
        '/get-product-variants-possibilities', [
        'as' => 'get.product.variants.possibilities',
        'uses' => 'ProductController@getProductVariantsPossibilities',
    ]
    );
    Route::get('product/grid', 'ProductController@grid')->name('product.grid');
    Route::resource('product', 'ProductController');
    Route::delete('product/{id}/delete', 'ProductController@fileDelete')->name('products.file.delete');
    Route::post('product/{id}/update', 'ProductController@productUpdate')->name('products.update');
}
);

Route::get(
    'get-products-variant-quantity', [
    'as' => 'get.products.variant.quantity',
    'uses' => 'ProductController@getProductsVariantQuantity',
]
);
Route::resource('store-resource', 'StoreController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('page/{slug?}', 'StoreController@pageOptionSlug')->name('pageoption.slug');
Route::get('store-blog/{slug?}', 'StoreController@StoreBlog')->name('store.blog');
Route::get('store-blog-view/{slug?}/blog/{id}', 'StoreController@StoreBlogView')->name('store.store_blog_view');

Route::get('store/{slug?}', 'StoreController@storeSlug')->name('store.slug');
Route::get('user-cart-item/{slug?}/cart', 'StoreController@StoreCart')->name('store.cart');
Route::post('store/{slug?}', 'StoreController@changeTheme')->name('store.changetheme');
/*LMS STORE*/
Route::get('{slug?}/view-course/{id}', 'StoreController@ViewCourse')->name('store.viewcourse');
Route::get('{slug?}/tutor/{id}', 'StoreController@tutor')->name('store.tutor');
Route::get('{slug?}/search-data/{search}', 'StoreController@searchData')->name('store.searchData');
Route::post('{slug?}/filter', 'StoreController@filter')->name('store.filter');
Route::get('{slug?}/search/{search?}/{category?}', 'StoreController@search')->name('store.search');
Route::get('{slug}/checkout/{id}/{total}', 'StoreController@checkout')->name('store.checkout');
Route::get('{slug}/user-create', 'StoreController@userCreate')->name('store.usercreate');
Route::post('{slug}/user-create', 'StoreController@userStore')->name('store.userstore');
Route::get('{slug}/fullscreen/{course}/{id?}/{type?}', 'StoreController@fullscreen')->name('store.fullscreen')->middleware('studentAuth');
//Student SIDE
Route::get('{slug}/student-home', 'StoreController@studentHome')->name('student.home')->middleware('studentAuth');
Route::get('{slug}/student-wishlist', 'StoreController@wishlistpage')->name('student.wishlist')->middleware('studentAuth');
/*WISHLIST*/
Route::post('{slug}/student-addtowishlist/{id}', 'StoreController@wishlist')->name('student.addToWishlist');
Route::post('{slug}/student-removefromwishlist/{id}', 'StoreController@removeWishlist')->name('student.removeFromWishlist')->middleware('studentAuth');
/*CHECKBOX*/
Route::post('student-watched/{id}/{course_id}/{slug?}', 'StoreController@checkbox')->name('student.checkbox');
Route::post('student-remove-watched/{id}/{course_id}/{slug?}', 'StoreController@removeCheckbox')->name('student.remove.checkbox');

Route::get('{slug?}/edit-products/{theme?}', 'StoreController@Editproducts')->name('store.editproducts')->middleware(['auth','XSS']);
Route::post('{slug?}/store-edit-products/{theme?}', 'StoreController@StoreEditProduct')->name('store.storeeditproducts')->middleware(['auth']);
/**/
Route::get('user-address/{slug?}/useraddress', 'StoreController@userAddress')->name('user-address.useraddress');
Route::get('store-payment/{slug?}/userpayment', 'StoreController@userPayment')->name('store-payment.payment');
Route::get('store/{slug?}/product/{id}', 'StoreController@productView')->name('store.product.product_view');
Route::post('user-product_qty/{slug?}/product/{id}/{variant_id?}', 'StoreController@productqty')->name('user-product_qty.product_qty');
Route::post('customer/{slug?}', 'StoreController@customer')->name('store.customer');
Route::post('user-location/{slug}/location/{id}', 'StoreController@UserLocation')->name('user.location');
Route::post('user-shipping/{slug}/shipping/{id}', 'StoreController@UserShipping')->name('user.shipping');
Route::post('save-rating/{slug?}', 'StoreController@saverating')->name('store.saverating');
Route::delete('delete_cart_item/{slug?}/product/{id}/{variant_id?}', 'StoreController@delete_cart_item')->name('delete.cart_item');

Route::get('store-complete/{slug?}/{id}', 'StoreController@complete')->name('store-complete.complete');

Route::post('add-to-cart/{slug?}/{id}/{variant_id?}', 'StoreController@addToCart')->name('user.addToCart');

Route::group(
    ['middleware' => ['XSS']], function (){
    Route::get('order', 'StripePaymentController@index')->name('order.index');
    Route::post('/stripe/{slug?}', 'StripePaymentController@stripePost')->name('stripe.post');
    Route::post('stripe-payment', 'StripePaymentController@addpayment')->name('stripe.payment');
}
);

Route::post('pay-with-paypal/{slug?}', 'PaypalController@PayWithPaypal')->name('pay.with.paypal')->middleware(['XSS']);

Route::get('{id}/get-payment-status{slug?}', 'PaypalController@GetPaymentStatus')->name('get.payment.status')->middleware(['XSS']);

Route::get('{slug?}/order/{id}', 'StoreController@userorder')->name('user.order');

Route::post('{slug?}/whatsapp', 'StoreController@whatsapp')->name('user.whatsapp');
Route::post('{slug?}/cod', 'StoreController@cod')->name('user.cod');
Route::post('{slug?}/bank_transfer', 'StoreController@bank_transfer')->name('user.bank_transfer');

Route::get(
    '/apply-coupon', [
    'as' => 'apply.coupon',
    'uses' => 'CouponController@applyCoupon',
]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/apply-productcoupon', [
    'as' => 'apply.productcoupon',
    'uses' => 'ProductCouponController@applyProductCoupon',
]
);

Route::resource('coupons', 'CouponController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'qr-code', function (){
    return QrCode::generate();
}
);
Route::get('change-language-store/{slug?}/{lang}', 'LanguageController@changeLanquageStore')->name('change.languagestore')->middleware(['XSS']);

Route::resource('product-coupon', 'ProductCouponController')->middleware(
    [
        'auth',
        'XSS',
    ]
);


//    Payments Callbacks

Route::get('paystack/{slug}/{code}/{order_id}', 'PaymentController@paystackPayment')->name('paystack');
Route::get('flutterwave/{slug}/{tran_id}/{order_id}', 'PaymentController@flutterwavePayment')->name('flutterwave');
Route::get('razorpay/{slug}/{pay_id}/{order_id}', 'PaymentController@razerpayPayment')->name('razorpay');
Route::post('{slug}/paytm/prepare-payments/', 'PaymentController@paytmOrder')->name('paytm.prepare.payments');
Route::post('paytm/callback/', 'PaymentController@paytmCallback')->name('paytm.callback');
Route::post('{slug}/mollie/prepare-payments/', 'PaymentController@mollieOrder')->name('mollie.prepare.payments');
Route::get('{slug}/{order_id}/mollie/callback/', 'PaymentController@mollieCallback')->name('mollie.callback');
Route::post('{slug}/mercadopago/prepare-payments/', 'PaymentController@mercadopagoPayment')->name('mercadopago.prepare');
Route::any('{slug}/mercadopago/callback/', 'PaymentController@mercadopagoCallback')->name('mercado.callback');

Route::post('{slug}/coingate/prepare-payments/', 'PaymentController@coingatePayment')->name('coingate.prepare');
Route::get('coingate/callback', 'PaymentController@coingateCallback')->name('coingate.callback');

Route::post('{slug}/skrill/prepare-payments/', 'PaymentController@skrillPayment')->name('skrill.prepare.payments');
Route::get('skrill/callback', 'PaymentController@skrillCallback')->name('skrill.callback');
Route::get('skrill/callback', 'PaymentController@skrillCallback')->name('skrill.callback');


//ORDER PAYMENTWALL
Route::post('{slug}/paymentwall/store-slug/', 'StoreController@paymentwallstoresession')->name('paymentwall.session.store');
Route::any('/{slug}/paymentwall/order',['as' => 'paymentwall.index','uses'=>'PaymentController@paymentwallPayment']);
Route::any('/{slug}/paymentwall/callback', 'PaymentController@paymentwallCallback')->name('paymentwall.callback');
Route::any('/{slug}/order/error/{flag}', 'PaymentController@orderpaymenterror')->name('order.callback.error');


/*LMS Owner*/

/*STORE EDIT*/
Route::post('{slug?}/store-edit', 'StoreController@StoreEdit')->name('store.storeedit')->middleware(['auth']);
Route::delete('{slug?}/brand/{id}/delete/', 'StoreController@brandfileDelete')->name('brand.file.delete')->middleware(['auth']);

//Course
Route::resource('course', 'CourseController')->middleware(['auth']);
Route::post('course/getsubcategory', 'CourseController@getsubcategory')->name('course.getsubcategory')->middleware(['auth']);

/*Practices*/
Route::post('course/practices-files/{id}', 'CourseController@practicesFiles')->name('course.practicesfiles')->middleware(['auth']);
Route::delete('course/practices-files/{id}/delete', 'CourseController@fileDelete')->name('practices.file.delete')->middleware(['auth']);
Route::get('course/practices-files-name/{id}/file-name', 'CourseController@editFileName')->name('practices.filename.edit')->middleware(['auth']);
Route::put('course/practices-files-update/{id}/file-name', 'CourseController@updateFileName')->name('practices.filename.update')->middleware(['auth']);


//Category
Route::resource('category', 'CategoryController')->middleware(['auth']);

//Subcategory
Route::resource('subcategory', 'SubcategoryController')->middleware(['auth']);
Route::get('content/{id}', 'SubcategoryController@viewcontent')->name('subcategory.viewcontent')->middleware(['auth']);

//Quiz
Route::resource('setquiz', 'QuizSettingsController')->middleware(['auth']);

Route::resource('quizbank', 'QuizBankController')->middleware(['auth']);
Route::get('content/{id}', 'QuizBankController@viewcontent')->name('quizbank.viewcontent')->middleware(['auth']);

//Sub content
Route::resource('subcontent', 'SubContentController')->middleware(['auth']);
Route::get('contents/{id}', 'SubContentController@viewcontent')->name('subcontent.viewcontent')->middleware(['auth']);
Route::delete('contents/{id}/delete', 'SubContentController@fileDelete')->name('subcontent.file.delete')->middleware(['auth']);
Route::post('contents/{id}/update', 'SubContentController@ContentsUpdate')->name('subcontent.update')->middleware(['auth']);

//Headers
Route::resource('{id}/headers', 'HeaderController')->middleware(['auth']);
Route::get('header/{id}', 'HeaderController@viewpage')->name('headers.viewpage')->middleware(['auth']);

//FAQs
Route::resource('{id}/faqs', 'FaqController')->middleware(['auth']);

//Chapters
Route::resource('{course_id}/{id}/chapters', 'ChaptersController')->middleware(['auth']);
Route::delete('chapters/{id}/delete', 'ChaptersController@fileDelete')->name('chapters.file.delete')->middleware(['auth']);
Route::post('chapters/{id}/update', 'ChaptersController@ContentsUpdate')->name('chapters.update')->middleware(['auth']);



//================================= Custom Landing Page ====================================//
Route::get('/landingpage', 'LandingPageSectionsController@index')->name('custom_landing_page.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionsController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionsController@setConetent')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionsController@removeSection')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/setOrder', 'LandingPageSectionsController@setOrder')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/copySection', 'LandingPageSectionsController@copySection')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//==================================== Import/Export Data Route ====================================//
Route::get('export/course','CourseController@export')->name('course.export');

Route::get('export/order','OrderController@export')->name('order.export');

Route::get('export/product-coupon', 'ProductCouponController@export')->name('product-coupon.export');
Route::get('import/product-coupon/file', 'ProductCouponController@importFile')->name('product-coupon.file.import');
Route::post('import/product-coupon', 'ProductCouponController@import')->name('product-coupon.import');

//==================================== Zoom-Meetings ====================================//
Route::any('zoom-meeting/calendar', 'ZoomMeetingController@calender')->name('zoom-meeting.calender')->middleware(['auth','XSS']); 

Route::resource('zoom-meeting', 'ZoomMeetingController')->middleware(['auth','XSS']);

Route::get('get-students/{course_id}', 'ZoomMeetingController@courseByStudentId')->name('course.by.student.id')->middleware(['auth','XSS']);

//==================================== Slack ====================================//
Route::post('setting/slack','SettingController@slack')->name('slack.setting');

//==================================== Telegram ====================================//
Route::post('setting/telegram','SettingController@telegram')->name('telegram.setting');

//==================================== Recaptcha ====================================//
Route::post('/recaptcha-settings',['as' => 'recaptcha.settings.store','uses' =>'SettingController@recaptchaSettingStore'])->middleware(['auth','XSS']);

//==================================== Download button ====================================//
Route::get('certificate/pdf/{id}', 'StoreController@certificatedl')->name('certificate.pdf')->middleware(['XSS']);

//==================================== Reset-password for store ====================================//
// Route::any('store-reset-password/{id}', 'StoreController@ownerPassword')->name('store.reset');
// Route::post('store-reset-password/{id}', 'StoreController@ownerPasswordReset')->name('store.password.update');
