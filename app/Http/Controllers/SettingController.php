<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Store;
use App\Models\Utility;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\Resources\Invoice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $user                 = Auth::user();
        $settings             = Utility::settings();
        $notifications        = Utility::notifications();
        $getStoreThemeSetting = Utility::getStoreThemeSetting($user->current_store);

        $store_settings = Store::where('id', $user->current_store)->first();

        if($store_settings)
        {
            $store_payment_setting = Utility::getPaymentSetting();

            $store = Store::saveCertificate();

            $serverName = str_replace(
                [
                    'http://',
                    'https://',
                ], '', env('APP_URL')
            );
            $serverIp   = gethostbyname($serverName);
            if($serverIp != $serverName)
            {
                $serverIp;
            }
            else
            {
                $serverIp = request()->server('SERVER_ADDR');
            }

            $app_url                     = trim(env('APP_URL'), '/');
            $store_settings['store_url'] = $app_url . '/store/' . $store_settings['slug'];

            if(!empty($store_settings->enable_subdomain) && $store_settings->enable_subdomain == 'on')
            {
                // Remove the http://, www., and slash(/) from the URL
                $input = env('APP_URL');

                // If URI is like, eg. www.way2tutorial.com/
                $input = trim($input, '/');
                // If not have http:// or https:// then prepend it
                if(!preg_match('#^http(s)?://#', $input))
                {
                    $input = 'http://' . $input;
                }

                $urlParts = parse_url($input);

                // Remove www.
                $subdomain_name = preg_replace('/^www\./', '', $urlParts['host']);
                // Output way2tutorial.com
            }
            else
            {
                $subdomain_name = str_replace(
                    [
                        'http://',
                        'https://',
                    ], '', env('APP_URL')
                );
            }

            return view('settings.index', compact('getStoreThemeSetting', 'settings', 'store_settings', 'serverIp', 'subdomain_name', 'store_payment_setting','store','notifications'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function saveBusinessSettings(Request $request)
    {
        $user = \Auth::user();
        if(\Auth::user()->type == 'Owner')
        {
            if($request->company_logo)
            {
                $request->validate(
                    [
                        'company_logo' => 'image|mimes:png|max:20480',
                    ]
                );
                $logoName = $user->id . '_logo.png';
                $path     = $request->file('company_logo')->storeAs('uploads/logo/', $logoName);
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $logoName,
                                                                                                                                                 'company_logo',
                                                                                                                                                 \Auth::user()->current_store,
                                                                                                                                             ]
                );
            }
            if($request->company_favicon)
            {
                $request->validate(
                    [
                        'company_favicon' => 'image|mimes:png|max:20480',
                    ]
                );
                $favicon = $user->id . '_favicon.png';
                $path    = $request->file('company_favicon')->storeAs('uploads/logo/', $favicon);
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $favicon,
                                                                                                                                                 'company_favicon',
                                                                                                                                                 \Auth::user()->current_store,
                                                                                                                                             ]
                );
            }

            $arrEnv = [
                'SITE_RTL' => !isset($request->SITE_RTL) ? 'off' : 'on',
            ];
            Utility::setEnvironmentValue($arrEnv);

            if(!empty($request->title_text) || !empty($request->footer_text) || !empty($request->site_date_format) || !empty($request->site_time_format) || !empty($request->display_landing_page))
            {
                $post = $request->all();
                if(!isset($request->display_landing_page))
                {
                    $post['display_landing_page'] = 'off';
                }


                unset($post['_token'], $post['company_logo'], $post['company_small_logo'], $post['company_favicon']);
                foreach($post as $key => $data)
                {
                    \DB::insert(
                        'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                     $data,
                                                                                                                                                     $key,
                                                                                                                                                     \Auth::user()->current_store,
                                                                                                                                                 ]
                    );
                }
            }
            if(!empty($request->logo))
                {
                    $filenameWithExt = $request->file('logo')->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('logo')->getClientOriginalExtension();
                    $fileNameToStore = 'logo' . '.' . $extension;
                    $dir             = storage_path('uploads/store_logo/');
                    if(!file_exists($dir))
                    {
                        mkdir($dir, 0777, true);
                    }
                    $path = $request->file('logo')->storeAs('uploads/store_logo/', $fileNameToStore);
                }
            if(!empty($request->logo))
            {
                $extension              = $request->file('logo')->getClientOriginalExtension();
                $fileNameToStoreInvoice = 'invoice_logo' . '.' . $extension;
                $dir                    = storage_path('uploads/store_logo/');
                if(!file_exists($dir))
                {
                    mkdir($dir, 0777, true);
                }
                $path = $request->file('logo')->storeAs('uploads/store_logo/', $fileNameToStoreInvoice);
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        Artisan::call('config:cache');
	    Artisan::call('config:clear');

        return redirect()->back()->with('success', __('Business setting succefully created.'));
    }

    public function saveCompanySettings(Request $request)
    {
        if(\Auth::user()->type == 'Owner')
        {
            $request->validate(
                [
                    'company_name' => 'required|string|max:50',
                    'company_email' => 'required',
                    'company_email_from_name' => 'required|string',
                ]
            );
            $post = $request->all();
            unset($post['_token']);

            foreach($post as $key => $data)
            {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                 $data,
                                                                                                                                                 $key,
                                                                                                                                                 \Auth::user()->current_store,
                                                                                                                                             ]
                );
            }

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveEmailSettings(Request $request)
    {
        $request->validate(
            [
                'mail_driver' => 'required|string|max:50',
                'mail_host' => 'required|string|max:50',
                'mail_port' => 'required|string|max:50',
                'mail_username' => 'required|string|max:50',
                'mail_password' => 'required|string|max:50',
                'mail_encryption' => 'required|string|max:50',
                'mail_from_address' => 'required|string|max:50',
                'mail_from_name' => 'required|string|max:50',
            ]
        );

        $arrEnv = [
            'MAIL_DRIVER' => $request->mail_driver,
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_ENCRYPTION' => $request->mail_encryption,
            'MAIL_FROM_NAME' => $request->mail_from_name,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
        ];
        Utility::setEnvironmentValue($arrEnv);

        Artisan::call('config:cache');
	    Artisan::call('config:clear');
        return redirect()->back()->with('success', __('Setting successfully updated.'));
    }

    public function saveSystemSettings(Request $request)
    {
        if(\Auth::user()->type == 'Owner')
        {
            $request->validate(
                [
                    'site_currency' => 'required',
                ]
            );
            $post = $request->all();
            unset($post['_token']);
            if(!isset($post['shipping_display']))
            {
                $post['shipping_display'] = 'off';
            }
            foreach($post as $key => $data)
            {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                                                 $data,
                                                                                                                                                                                 $key,
                                                                                                                                                                                 \Auth::user()->current_store,
                                                                                                                                                                                 date('Y-m-d H:i:s'),
                                                                                                                                                                                 date('Y-m-d H:i:s'),
                                                                                                                                                                             ]
                );
            }

            return redirect()->back()->with('success', __('Setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveOwnerPaymentSettings(Request $request, $slug)
    {
        if(\Auth::user()->type == 'Owner')
        {
            $store = Store::where('slug', $slug)->first();

            $request->validate(
                [
                    'currency' => 'required|string|max:255',
                    'currency_symbol' => 'required|string|max:255',
                ]
            );

            if(isset($request->enable_stripe) && $request->enable_stripe == 'on')
            {
                $request->validate(
                    [
                        'stripe_key' => 'required|string|max:255',
                        'stripe_secret' => 'required|string|max:255',
                    ]
                );
            }
            elseif(isset($request->enable_paypal) && $request->enable_paypal == 'on')
            {
                $request->validate(
                    [
                        'paypal_mode' => 'required|string',
                        'paypal_client_id' => 'required|string',
                        'paypal_secret_key' => 'required|string',
                    ]
                );
            }
            elseif(isset($request->enable_bank) && $request->enable_bank == 'on')
            {
                $request->validate(
                    [
                        'bank_number' => 'required|string',
                    ]
                );
            }

            $store['currency']                 = $request->currency_symbol;
            $store['currency_code']            = $request->currency;
            $store['currency_symbol_position'] = $request->currency_symbol_position;
            $store['currency_symbol_space']    = $request->currency_symbol_space;
            $store['is_stripe_enabled']        = $request->is_stripe_enabled ?? 'off';
            $store['STRIPE_KEY']               = $request->stripe_key;
            $store['STRIPE_SECRET']            = $request->stripe_secret;
            $store['is_paypal_enabled']        = $request->is_paypal_enabled ?? 'off';
            $store['PAYPAL_MODE']              = $request->paypal_mode;
            $store['PAYPAL_CLIENT_ID']         = $request->paypal_client_id;
            $store['PAYPAL_SECRET_KEY']        = $request->paypal_secret_key;
            $store['ENABLE_WHATSAPP']          = $request->enable_whatsapp ?? 'off';
            $store['WHATSAPP_NUMBER']          = $request->whatsapp_number;
            $store['ENABLE_COD']               = $request->enable_cod ?? 'off';
            $store['ENABLE_BANK']              = $request->enable_bank ?? 'off';
            $store['BANK_NUMBER']              = $request->bank_number;

            $store->update();

            self::shopePaymentSettings($request);

            return redirect()->back()->with('success', __('Payment Store setting successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveOwneremailSettings(Request $request, $slug)
    {
        if(\Auth::user()->type == 'Owner')
        {
            $store = Store::where('slug', $slug)->first();

            $request->validate(
                [
                    'mail_driver' => 'required|string|max:50',
                    'mail_host' => 'required|string|max:50',
                    'mail_port' => 'required|string|max:50',
                    'mail_username' => 'required|string|max:50',
                    'mail_password' => 'required|string|max:50',
                    'mail_encryption' => 'required|string|max:50',
                    'mail_from_address' => 'required|string|max:50',
                    'mail_from_name' => 'required|string|max:50',
                ]
            );

            $store['mail_driver']       = $request->mail_driver;
            $store['mail_host']         = $request->mail_host;
            $store['mail_port']         = $request->mail_port;
            $store['mail_username']     = $request->mail_username;
            $store['mail_password']     = $request->mail_password;
            $store['mail_encryption']   = $request->mail_encryption;
            $store['mail_from_address'] = $request->mail_from_address;
            $store['mail_from_name']    = $request->mail_from_name;
            $store->update();

            return redirect()->back()->with('success', __('Email Store setting successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveCompanyPaymentSettings(Request $request)
    {
        if(\Auth::user()->type == 'Owner')
        {
            if(isset($request->enable_stripe) && $request->enable_stripe == 'on')
            {
                $request->validate(
                    [
                        'stripe_key' => 'required|string',
                        'stripe_secret' => 'required|string',
                    ]
                );
            }
            elseif(isset($request->enable_paypal) && $request->enable_paypal == 'on')
            {
                $request->validate(
                    [
                        'paypal_mode' => 'required|string',
                        'paypal_client_id' => 'required|string',
                        'paypal_secret_key' => 'required|string',
                    ]
                );
            }
            $post                  = $request->all();
            $post['enable_paypal'] = isset($request->enable_paypal) ? $request->enable_paypal : '';
            $post['enable_stripe'] = isset($request->enable_stripe) ? $request->enable_stripe : '';
            unset($post['_token']);
            foreach($post as $key => $data)
            {
                \DB::insert(
                    'insert into settings (`value`, `name`,`created_by`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                                                                                                                                                                                 $data,
                                                                                                                                                                                 $key,
                                                                                                                                                                                 \Auth::user()->current_store,
                                                                                                                                                                                 date('Y-m-d H:i:s'),
                                                                                                                                                                                 date('Y-m-d H:i:s'),
                                                                                                                                                                             ]
                );
            }

            return redirect()->back()->with('success', __('Payment setting successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function testMail()
    {
        return view('settings.test_mail');
    }

    public function testSendMail(Request $request)
    {
        if(\Auth::user()->type == 'super admin' || \Auth::user()->type == 'Owner')
        {
            $validator = \Validator::make($request->all(), ['email' => 'required|email']);
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            try
            {
                if(\Auth::user()->type != 'super admin')
                {
                    $store = Store::find(Auth::user()->current_store);
                    config(
                        [
                            'mail.driver' => $store->mail_driver,
                            'mail.host' => $store->mail_host,
                            'mail.port' => $store->mail_port,
                            'mail.encryption' => $store->mail_encryption,
                            'mail.username' => $store->mail_username,
                            'mail.password' => $store->mail_password,
                            'mail.from.address' => $store->mail_from_address,
                            'mail.from.name' => $store->mail_from_name,
                        ]
                    );
                }

                Mail::to($request->email)->send(new TestMail());
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->back()->with('success', __('Email send Successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function shopePaymentSettings($request)
    {
        if(isset($request->is_stripe_enabled) && $request->is_stripe_enabled == 'on')
        {
            $request->validate(
                [
                    'stripe_key' => 'required|string|max:255',
                    'stripe_secret' => 'required|string|max:255',
                ]
            );
            $post['is_stripe_enabled'] = $request->is_stripe_enabled;
            $post['stripe_key']        = $request->stripe_key;
            $post['stripe_secret']     = $request->stripe_secret;
        }
        else
        {
            $post['is_stripe_enabled'] = $request->is_stripe_enabled;
        }

        if(isset($request->is_paypal_enabled) && $request->is_paypal_enabled == 'on')
        {
            $request->validate(
                [
                    'paypal_mode' => 'required|string',
                    'paypal_client_id' => 'required|string',
                    'paypal_secret_key' => 'required|string',
                ]
            );
            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
            $post['paypal_mode']       = $request->paypal_mode;
            $post['paypal_client_id']  = $request->paypal_client_id;
            $post['paypal_secret_key'] = $request->paypal_secret_key;
        }
        else
        {
            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
        }

        if(isset($request->is_paystack_enabled) && $request->is_paystack_enabled == 'on')
        {
            $request->validate(
                [
                    'paystack_public_key' => 'required|string',
                    'paystack_secret_key' => 'required|string',
                ]
            );
            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
            $post['paystack_public_key'] = $request->paystack_public_key;
            $post['paystack_secret_key'] = $request->paystack_secret_key;
        }
        else
        {
            $post['is_paystack_enabled'] = $request->is_paystack_enabled;
        }

        if(isset($request->is_flutterwave_enabled) && $request->is_flutterwave_enabled == 'on')
        {
            $request->validate(
                [
                    'flutterwave_public_key' => 'required|string',
                    'flutterwave_secret_key' => 'required|string',
                ]
            );
            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
            $post['flutterwave_public_key'] = $request->flutterwave_public_key;
            $post['flutterwave_secret_key'] = $request->flutterwave_secret_key;
        }
        else
        {
            $post['is_flutterwave_enabled'] = $request->is_flutterwave_enabled;
        }

        if(isset($request->is_razorpay_enabled) && $request->is_razorpay_enabled == 'on')
        {
            $request->validate(
                [
                    'razorpay_public_key' => 'required|string',
                    'razorpay_secret_key' => 'required|string',
                ]
            );
            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
            $post['razorpay_public_key'] = $request->razorpay_public_key;
            $post['razorpay_secret_key'] = $request->razorpay_secret_key;
        }
        else
        {
            $post['is_razorpay_enabled'] = $request->is_razorpay_enabled;
        }

        if(isset($request->is_paytm_enabled) && $request->is_paytm_enabled == 'on')
        {
            $request->validate(
                [
                    'paytm_mode' => 'required',
                    'paytm_merchant_id' => 'required|string',
                    'paytm_merchant_key' => 'required|string',
                    'paytm_industry_type' => 'required|string',
                ]
            );
            $post['is_paytm_enabled']    = $request->is_paytm_enabled;
            $post['paytm_mode']          = $request->paytm_mode;
            $post['paytm_merchant_id']   = $request->paytm_merchant_id;
            $post['paytm_merchant_key']  = $request->paytm_merchant_key;
            $post['paytm_industry_type'] = $request->paytm_industry_type;
        }
        else
        {
            $post['is_paytm_enabled'] = $request->is_paytm_enabled;
        }

        if(isset($request->is_mercado_enabled) && $request->is_mercado_enabled == 'on')
        {
            $request->validate(
                [
                    'mercado_access_token' => 'required|string',
                ]
            );
            $post['is_mercado_enabled']   = $request->is_mercado_enabled;
            $post['mercado_access_token'] = $request->mercado_access_token;
            $post['mercado_mode']         = $request->mercado_mode;
        }
        else
        {
            $post['is_mercado_enabled'] = 'off';
        }


        if(isset($request->is_mollie_enabled) && $request->is_mollie_enabled == 'on')
        {
            $request->validate(
                [
                    'mollie_api_key' => 'required|string',
                    'mollie_profile_id' => 'required|string',
                    'mollie_partner_id' => 'required',
                ]
            );
            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
            $post['mollie_api_key']    = $request->mollie_api_key;
            $post['mollie_profile_id'] = $request->mollie_profile_id;
            $post['mollie_partner_id'] = $request->mollie_partner_id;
        }
        else
        {
            $post['is_mollie_enabled'] = $request->is_mollie_enabled;
        }

        if(isset($request->is_skrill_enabled) && $request->is_skrill_enabled == 'on')
        {
            $request->validate(
                [
                    'skrill_email' => 'required|email',
                ]
            );
            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
            $post['skrill_email']      = $request->skrill_email;
        }
        else
        {
            $post['is_skrill_enabled'] = $request->is_skrill_enabled;
        }

        if(isset($request->is_coingate_enabled) && $request->is_coingate_enabled == 'on')
        {
            $request->validate(
                [
                    'coingate_mode' => 'required|string',
                    'coingate_auth_token' => 'required|string',
                ]
            );

            $post['is_coingate_enabled'] = $request->is_coingate_enabled;
            $post['coingate_mode']       = $request->coingate_mode;
            $post['coingate_auth_token'] = $request->coingate_auth_token;
        }
        else
        {
            $post['is_paypal_enabled'] = $request->is_paypal_enabled;
        }

        if(isset($request->is_paymentwall_enabled) && $request->is_paymentwall_enabled == 'on')
        {
            $request->validate(
                [
                    'paymentwall_public_key' => 'required|string',
                    'paymentwall_secret_key' => 'required|string',
                ]
            );
            $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;
            $post['paymentwall_public_key'] = $request->paymentwall_public_key;
            $post['paymentwall_secret_key'] = $request->paymentwall_secret_key;
        }
        else
        {
            $post['is_paymentwall_enabled'] = $request->is_paymentwall_enabled;
        }

        foreach($post as $key => $data)
        {

            $arr = [
                $data,
                $key,
                Auth::user()->current_store,
                Auth::user()->creatorId(),
            ];
            \DB::insert(
                'insert into store_payment_settings (`value`, `name`, `store_id`,`created_by`) values (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', $arr
            );

        }
    }

    public function previewCertificate($template, $color,$gradiants)
    {
        $objUser  = \Auth::user();
        $settings = Store::saveCertificate();

        $user   = Student::where('id', $objUser->id)->first();
        $course_id = Course::where('id' , $user->courses_id)->first();
       
        $certificate  = new Certificate();

        $student                = new \stdClass();
        $student->name          = '<Name>';
        $student->course_name   = '<Course Name>';  
        $student->course_time   = '<Course Time>';    

        $preview    = 1;
        $color      = '#' . $color;       
        $font_color = Utility::getFontColor($color);
        $gradiant   = $gradiants;

        $logo         = asset(Storage::url('logo/'));
        $company_logo = Utility::getValByName('company_logo');
        $img          = asset($logo . '/' .'logo-invoice.png');

        return view('settings.templates.' . $template, compact('certificate', 'preview', 'color', 'img', 'settings', 'student', 'font_color','gradiant','course_id'));
    }

    public function saveCertificateSettings(Request $request)
    {       
        $storeId = \Auth::user()->current_store;
        $post = $request->all();
        unset($post['_token']);

        if(isset($post['certificate_template']) && (!isset($post['certificate_color']) || empty($post['certificate_color'])))
        {
            $post['certificate_color'] = "ffffff";
        }

        $store = Store::find($storeId);
        $store->certificate_template  = $request->certificate_template;
        $store->certificate_color     = $request->certificate_color;
        $store->certificate_gradiant  = $request->gradiant;
        $store->header_name           = $request->header_name;
        $store->save();
        // dd($store);
        
        return redirect()->back()->with('success', __('Certificate Setting updated successfully'));       
    }

    public function slack(Request $request)
    {
        $post = [];
        $post['slack_webhook'] = $request->input('slack_webhook');
        $post['course_notification'] = $request->has('course_notification')?$request->input('course_notification'):0;
        $post['store_notification'] = $request->has('store_notification')?$request->input('store_notification'):0;
        $post['order_notification'] = $request->has('order_notification')?$request->input('order_notification'):0;
        $post['zoom_meeting_notification'] = $request->has('zoom_meeting_notification')?$request->input('zoom_meeting_notification'):0;
        
        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                \DB::insert(
                    'INSERT INTO notifications (`value`, `name`,`store_id`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                                    $data,
                                                                                                                                                                                                                                    $key,
                                                                                                                                                                                                                                    Auth::user()->current_store,
                                                                                                                                                                                                                                    $created_at,
                                                                                                                                                                                                                                    $updated_at,
                                                                                                                                                                                                                                ]
                );
            }
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }

    public function telegram(Request $request)
    {
        $post = [];
        $post['telegram_accestoken'] = $request->input('telegram_accestoken');
        $post['telegram_chatid'] = $request->input('telegram_chatid');
        $post['telegram_course_notification'] = $request->has('telegram_course_notification')?$request->input('telegram_course_notification'):0;
        $post['telegram_store_notification'] = $request->has('telegram_store_notification')?$request->input('telegram_store_notification'):0;
        $post['telegram_order_notification'] = $request->has('telegram_order_notification')?$request->input('telegram_order_notification'):0;
        $post['telegram_zoom_meeting_notification'] = $request->has('telegram_zoom_meeting_notification')?$request->input('telegram_zoom_meeting_notification'):0;

        if(isset($post) && !empty($post) && count($post) > 0)
        {
            $created_at = $updated_at = date('Y-m-d H:i:s');

            foreach($post as $key => $data)
            {
                DB::insert(
                    'INSERT INTO notifications (`value`, `name`,`store_id`,`created_at`,`updated_at`) values (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`) ', [
                                                                                                                                                                                                                                    $data,
                                                                                                                                                                                                                                    $key,
                                                                                                                                                                                                                                    Auth::user()->current_store,
                                                                                                                                                                                                                                    $created_at,
                                                                                                                                                                                                                                    $updated_at,
                                                                                                                                                                                                                                ]
                );
            }
        }

        return redirect()->back()->with('success', __('Settings updated successfully.'));
    }

    public function recaptchaSettingStore(Request $request)
    {
        //return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        $user = \Auth::user();
        $rules = [];

        if($request->recaptcha_module == 'yes')
        {
            $rules['google_recaptcha_key'] = 'required|string|max:50';
            $rules['google_recaptcha_secret'] = 'required|string|max:50';
        }

        $validator = \Validator::make(
            $request->all(), $rules
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $arrEnv = [
            'RECAPTCHA_MODULE' => $request->recaptcha_module ?? 'no',
            'NOCAPTCHA_SITEKEY' => $request->google_recaptcha_key,
            'NOCAPTCHA_SECRET' => $request->google_recaptcha_secret,
        ];

        if(Utility::setEnvironmentValue($arrEnv))
        {
            return redirect()->back()->with('success', __('Recaptcha Settings updated successfully'));
        }
        else
        {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

}
