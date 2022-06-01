<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\Utility;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('auth.register');
    }


    protected function validator(array $data)
    {
        return Validator::make(
            $data, [
                     'name' => [
                         'required',
                         'string',
                         'max:255',
                     ],
                     'store_name' => [
                         'required',
                         'string',
                         'max:255',
                     ],
                     'email' => [
                         'required',
                         'string',
                         'email',
                         'max:255',
                         'unique:users',
                     ],
                     'password' => [
                         'required',
                         'string',
                         'min:8',
                         'confirmed',
                     ],
                 ]
        );
    }


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    protected function create(array $data)
    {
        $settings = Utility::settings();
        $objUser  = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => 'Owner',
                'lang' => !empty($settings['default_language']) ? $settings['default_language'] : 'en',
                'avatar' => 'avatar.png',
                'created_by' => 1,
            ]
        );

        $objStore  = Store::create(
            [
                'created_by' => $objUser->id,
                'name' => $data['store_name'],
                'email' => $data['email'],
                'logo' => !empty($settings['logo']) ? $settings['logo'] : 'logo.png',
                'invoice_logo' => !empty($settings['logo']) ? $settings['logo'] : 'logo.png',
                'lang' => !empty($settings['default_language']) ? $settings['default_language'] : 'en',
                'currency' => !empty($settings['currency_symbol']) ? $settings['currency_symbol'] : '$',
                'currency_code' => !empty($settings->currency) ? $settings->currency : 'USD',
                'paypal_mode' => 'sandbox',
            ]
        );

        $objStore->enable_storelink = 'on';
        $objStore->save();

        $objUser->current_store = $objStore->id;
        $objUser->save();
        UserStore::create(
            [
                'user_id' => $objUser->id,
                'store_id' => $objStore->id,
                'permission' => 'Owner',
            ]
        );

        return $objUser;
    }

    public function showRegistrationForm($lang = 'en')
    {
        if($lang == '')
        {
            $lang = \App\Utility::getValByName('default_language');
        }
        \App::setLocale($lang);

        return view('auth.register', compact('lang'));
    }




    public function store(Request $request)
    {
        if(env('RECAPTCHA_MODULE') == 'yes')
        {
            $validation['g-recaptcha-response'] = 'required|captcha';
        }else
        { 
            $validation=[];
        }        
        $this->validate($request, $validation);

        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' =>$request->name,
            'name' =>$request->name,
            'email' =>$request->email,
            'password' => Hash::make($request->password),
            'type' => 'owner',
            'lang' => 'en',
            'title' => '-',
            'avatar' => '',
            'plan' => Plan::first()->id,
            'created_by' => 1,
        ]);

        $adminRole = Role::findByName('owner');

        $user->assignRole($adminRole);

//        $user->assignPlan(1);
//
//        $user->userDefaultData();
//
//        $user->makeEmployeeRole();
//
        event(new Registered($user));

        Auth::login($user);


        return redirect(RouteServiceProvider::HOME);

    }

    public function showRegistrationForm($lang = 'en')
    {
        if($lang == '')
        {
            $lang = Utility::getValByName('default_language');
        }

        \App::setLocale($lang);

        return view('auth.register', compact('lang'));
    }
}
