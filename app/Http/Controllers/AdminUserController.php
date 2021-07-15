<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Customer;
use App\Setup_config;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller maintains the users details as well as their
    | validation and updation. 
    |
    */

    public function index()
    {
        $admin_users = User::where('is_admin', '<>', 1)->get();
        $payout = Setup_config::where('type', 'payout')->first();
        $payout_status = '0';
        if($payout!=null){
            $payout_status = $payout->value;
        }
        return view('admin-users', ['admin_users' => $admin_users, 'payout' => $payout_status]);
    }

    public function manage(Request $request){
        $id = $request->id;
        $admin_user = User::where('id', $id)->first();
        return view('manage-users', ['admin_user' => $admin_user]);
    }

    public function save(Request $request){
        $id = $request->id;
        if($id == 0){
            $admin_user = new User;
            $admin_user->name = $request->firstname." ".$request->lastname;
            $admin_user->company = $request->company;
            $admin_user->phone = $request->phone;
            $admin_user->email = $request->email;
            $admin_user->address = $request->address;
            $admin_user->paypal_payout_email = $request->paypal_payout_email;
            $admin_user->username = $request->username;
            $admin_user->password = Hash::make($request->password);
            $admin_user->commission_fee = $request->commission_fee;
            $admin_user->commission = "0";
            $admin_user->save();
        }else{
            $admin_user = User::where("id", $id)->first();
            $admin_user->name = $request->firstname." ".$request->lastname;
            $admin_user->company = $request->company;
            $admin_user->phone = $request->phone;
            $admin_user->email = $request->email;
            $admin_user->address = $request->address;
            $admin_user->paypal_payout_email = $request->paypal_payout_email;
            $admin_user->username = $request->username;
            $admin_user->commission_fee = $request->commission_fee;
            $admin_user->commission = $request->commission;
            if($request->password!="")
                $admin_user->password = Hash::make($request->password);
            $admin_user->save();
        }
        return redirect()->to('admin-users');
    }

    public function delete(Request $request){
        $id = $request->id;
        User::where('id', $id)->delete();
        $customers = Customer::where('admin_id', $id)->get();
        foreach($customers as $customer){
            $customer->admin_id = User::first()->id;
            $customer->save();
        }
        return redirect()->to('admin-users');
    }

    public function saveCommissionFee(Request $request){
        $commission_fee = $request->commission_fee;
        $checked_admin_users = $request->checked_admin_users;
        $checked_admin_users = explode(",", $checked_admin_users);
        foreach($checked_admin_users as $admin_user_id){
            $admin_user = User::find($admin_user_id);
            $admin_user->commission_fee = $commission_fee;
            $admin_user->save();
        }
        return redirect()->to('admin-users');
    }
    
    public function togglePayout(){
        $payout = Setup_config::where('type', 'payout')->first();
        if($payout->value=='1'){
            $payout->value = '0';
        }else{
            $payout->value = '1';
        }
        $payout->save();
        echo 1;
    }
}
