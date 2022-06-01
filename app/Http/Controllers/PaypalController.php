<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariantOption;
use App\Models\PurchasedCourse;
use App\Models\Shipping;
use App\Models\Store;
use App\Models\UserCoupon;
use App\Models\UserDetail;
use App\Models\UserStore;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalController extends Controller
{
    private $_api_context;

    public function setApiContext($slug = '')
    {
        if(Auth::check() && Auth::guard('students')->check() == false)
        {
            $admin_payment_setting           = Utility::getAdminPaymentSetting();
            $paypal_conf['settings']['mode'] = $admin_payment_setting['paypal_mode'];
            $paypal_conf['client_id']        = $admin_payment_setting['paypal_client_id'];
            $paypal_conf['secret_key']       = $admin_payment_setting['paypal_secret_key'];
        }
        else
        {
            $store                           = Store::where('slug', $slug)->first();
            $store_payment_setting           = Utility::getPaymentSetting($store->id);
            $paypal_conf['settings']['mode'] = $store_payment_setting['paypal_mode'];
            $paypal_conf['client_id']        = $store_payment_setting['paypal_client_id'];
            $paypal_conf['secret_key']       = $store_payment_setting['paypal_secret_key'];
        }

        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret_key']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function PayWithPaypal(Request $request, $slug)
    {
        $cart     = session()->get($slug);
        $products = $cart['products'];

        $store = Store::where('slug', $slug)->first();


        $total_price    = 0;
        $sub_tax        = 0;
        $sub_totalprice = 0;
        $total_tax      = 0;
        $product_name   = [];
        $product_id     = [];

        foreach($products as $key => $product)
        {
            $product_name[] = $product['product_name'];
            $product_id[]   = $product['id'];
            $sub_totalprice += $product['price'];
            $total_price    += $product['price'];
        }

        if($products)
        {
            try
            {
                $coupon_id = null;
                if(isset($cart['coupon']) && isset($cart['coupon']))
                {
                    if($cart['coupon']['coupon']['enable_flat'] == 'off')
                    {
                        $discount_value = ($sub_totalprice / 100) * $cart['coupon']['coupon']['discount'];
                        $total_price    = $sub_totalprice - $discount_value;
                    }
                    else
                    {
                        $discount_value = $cart['coupon']['coupon']['flat_discount'];
                        $total_price    = $sub_totalprice - $discount_value;
                    }
                }
                $this->setApiContext($slug);
                $name  = implode(',', $product_name);
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
                $item_1 = new Item();
                $item_1->setName($name)->setCurrency($store->currency_code)->setQuantity(1)->setPrice($total_price);
                $item_list = new ItemList();
                $item_list->setItems([$item_1]);
                $amount = new Amount();
                $amount->setCurrency($store->currency_code)->setTotal($total_price);
                $transaction = new Transaction();
                $transaction->setAmount($amount)->setItemList($item_list)->setDescription($name);
                $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(
                    route('get.payment.status', $store->slug)
                )->setCancelUrl(
                    route('get.payment.status', $store->slug)
                );
                $payment = new Payment();
                $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions([$transaction]);
                try
                {
                    $payment->create($this->_api_context);
                }
                catch(\PayPal\Exception\PayPalConnectionException $ex) //PPConnectionException
                {
                    return redirect()->back()->with('error', $ex->getMessage());
                }
                foreach($payment->getLinks() as $link)
                {
                    if($link->getRel() == 'approval_url')
                    {
                        $redirect_url = $link->getHref();
                        break;
                    }
                }
                Session::put('paypal_payment_id', $payment->getId());
                if(isset($redirect_url))
                {
                    return Redirect::away($redirect_url);
                }
                return redirect()->back()->with('error', __('Unknown error occurred'));
            }
            catch(\Exception $e)
            {
                return redirect()->back()->with('error', __('Unknown error occurred'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('is deleted.'));
        }
    }

    public function GetPaymentStatus(Request $request, $slug)
    {
        $cart = session()->get($slug);
        if(isset($cart['coupon']))
        {
            $coupon = $cart['coupon']['coupon'];
        }
        $products       = $cart['products'];
        $store          = Store::where('slug', $slug)->first();
        $sub_totalprice = 0;
        $product_name   = [];
        $product_id     = [];

        foreach($products as $key => $product)
        {
            $course = Course::where('id',$product['product_id'])->where('store_id',$store->id)->first();
            $product_name[] = $product['product_name'];
            $product_id[]   = $product['id'];
            $sub_totalprice += $product['price'];
        }
        if(!empty($coupon))
        {
            if($coupon['enable_flat'] == 'off')
            {
                $discount_value = ($sub_totalprice / 100) * $coupon['discount'];
                $totalprice     = $sub_totalprice - $discount_value;
            }
            else
            {
                $discount_value = $coupon['flat_discount'];
                $totalprice     = $sub_totalprice - $discount_value;
            }
        }
        if($product)
        {
            $this->setApiContext($slug);
            $payment_id = Session::get('paypal_payment_id');
            Session::forget('paypal_payment_id');
            if(empty($request->PayerID || empty($request->token)))
            {
                return redirect()->route('store-payment.payment', $slug)->with('error', __('Payment failed'));
            }
            $payment   = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);
            try
            {
                $result = $payment->execute($execution, $this->_api_context)->toArray();

                $order       = new Order();
                $latestOrder = Order::orderBy('created_at', 'DESC')->first();
                if(!empty($latestOrder))
                {
                    $order->order_nr = '#' . str_pad($latestOrder->id + 1, 4, "100", STR_PAD_LEFT);
                }
                else
                {
                    $order->order_nr = '#' . str_pad(1, 4, "100", STR_PAD_LEFT);

                }
                $orderID = $order->order_nr;

                $status = ucwords(str_replace('_', ' ', $result['state']));
                if($result['state'] == 'approved')
                {
                    $student               = Auth::guard('students')->user();
                    $order                 = new Order();
                    $order->order_id       = $orderID;
                    $order->name           = $student->name;
                    $order->card_number    = '';
                    $order->card_exp_month = '';
                    $order->card_exp_year  = '';
                    $order->student_id     = $student->id;
                    $order->course         = json_encode($products);
                    $order->price          = $result['transactions'][0]['amount']['total'];
                    $order->coupon         = !empty($cart['coupon']['coupon']['id']) ? $cart['coupon']['coupon']['id'] : '';
                    $order->coupon_json    = json_encode(!empty($coupon) ? $coupon : '');
                    $order->discount_price = !empty($cart['coupon']['discount_price']) ? $cart['coupon']['discount_price'] : '';
                    $order->price_currency = $store->currency_code;
                    $order->txn_id         = $payment_id;
                    $order->payment_type   = __('PAYPAL');
                    $order->payment_status = $result['state'];
                    $order->receipt        = '';
                    $order->store_id       = $store['id'];
                    $order->save();
 
                    $purchased_course = new PurchasedCourse();
                    foreach($course as $course_id)
                    {
                        $purchased_course->course_id  = $course_id;
                        $purchased_course->student_id = $student->id;
                        $purchased_course->order_id   = $order->id;
                        $purchased_course->save();
                    }

                    // slack // 
                    $settings  = Utility::notifications();
                    if(isset($settings['order_notification']) && $settings['order_notification'] ==1){
                        $msg = 'New Order '.$orderID.' is created by '.$store['name'].'.';
                        Utility::send_slack_msg($msg);    
                    }

                    // telegram // 
                    $settings  = Utility::notifications();
                    if(isset($settings['telegram_order_notification']) && $settings['telegram_order_notification'] ==1){
                        $msg = 'New Order '.$orderID.' is created by '.$store['name'].'.';
                        Utility::send_telegram_msg($msg);    
                    }

                    session()->forget($slug);

                    return redirect()->route(
                        'store-complete.complete', [
                                                     $store->slug,
                                                     Crypt::encrypt($order->id),
                                                 ]
                    )->with('success', __('Transaction has been') . $status);
                }
                else
                {
                    return redirect()->back()->with('error', __('Transaction has been') . $status);
                }
            }
            catch(\Exception $e)
            {
                return redirect()->back()->with('error', __('Transaction has been failed.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __(' is deleted.'));
        }
    }
}
