<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Setup_config;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\SocialProvider;
use App\Rules\Captcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            // 'dob' => ['required', 'date', 'before:today'],
            // 'avatar' => ['sometimes', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
            // 'g-recaptcha-response' => new Captcha()
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $commission_fee = Setup_config::where('type', 'commission_fee')->first()->value;
        if (request()->has('avatar')) {            
            $avataruloaded=request()->file('avatar');
            $avatarname= time().'.'.$avataruloaded->getClientOriginalExtension();
            $avatarpath= public_path('/images/');
            $avataruloaded->move($avatarpath,$avatarname);
            return User::create([
                'name' => $data['name'],
                'company' => $data['company'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'paypal_payout_email' => $data['paypal_payout_email'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                // 'dob' => $data['dob'],
                // 'avatar' => '/images/'.$avatarname,
                'commission_fee' => $commission_fee
            ]);
        }
        return User::create([
            'name' => $data['name'],
            'company' => $data['company'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'paypal_payout_email' => $data['paypal_payout_email'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            // 'dob' => $data['dob'],
            // 'avatar' => $data['avatar'],
            'commission_fee' => $commission_fee
        ]);
    }
}