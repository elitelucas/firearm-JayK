<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Customer;
use App\Setup_config;
use App\Evr_attendee;
use App\Evr_category;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    public function index(){
        $commission_fee = Setup_config::where('type', 'commission_fee')->first();
        $customer_message = Setup_config::where('type', 'customer_message')->first();
        $categories = Evr_category::all();
        $total_qty = 0;
        $total_order = 0;
        $paid_order = 0;
        $admin_received = 0;
        $user_received = 0;
        if(Auth::user()->is_admin==1){
            $customers = Customer::all();
            foreach($customers as $customer){
                $attendee = Evr_attendee::find($customer->attendee_id);
                if($attendee != null){
                    $total_qty += $attendee->quantity;
                    $total_order += $attendee->order_total;
                    if($attendee->payment_status=='success'){
                        $paid_order += $attendee->amount_pd;
                    }
                    $admin_user = User::find($customer->admin_id);
                    if($attendee->amount_pd!=null&&$attendee->amount_pd>0){
                        $admin_received += $attendee->amount_pd-($attendee->quantity*$admin_user->commission_fee);
                    }
                }
            }
            $admin_users = User::where('is_admin', 0)->get();
            foreach($admin_users as $admin_user){
                $admin_customers = Customer::where('admin_id', $admin_user->id)->get();
                $admin_user->total_qty = 0;
                $admin_user->total_order = 0;
                $admin_user->paid_order = 0;
                $admin_user->user_received = 0;
                foreach($admin_customers as $admin_customer){
                    $attendee = Evr_attendee::find($admin_customer->attendee_id);
                    if($attendee != null){
                        $admin_user->total_qty += $attendee->quantity;
                        $admin_user->total_order += $attendee->order_total;
                        if($attendee->payment_status=='success'){
                            $admin_user->paid_order += $attendee->amount_pd;
                        }
                        if($attendee->amount_pd!=null&&$attendee->amount_pd>0){
                            $user_received += $attendee->quantity*$admin_user->commission_fee;
                        }
                    }
                }
            }
        }else{
            $customers = Customer::where('admin_id', Auth::user()->id)->get();
            foreach($customers as $customer){
                $attendee = Evr_attendee::find($customer->attendee_id);
                if($attendee != null){
                    $total_qty += $attendee->quantity;
                    $total_order += $attendee->order_total;
                    if($attendee->payment_status=='success'){
                        $paid_order += $attendee->amount_pd;
                    }
                    if($attendee->amount_pd!=null&&$attendee->amount_pd>0){
                        $admin_received += $attendee->quantity*Auth::user()->commission_fee;
                    }
                }
            }
            $admin_users = User::where('id', Auth::user()->id)->get();
            $admin_users[0]->total_qty = $total_qty;
            $admin_users[0]->total_order = $total_order;
            $admin_users[0]->paid_order = $paid_order;
            $admin_users[0]->user_received = $admin_received;
        }
        return view('index', [
            'commission_fee' => $commission_fee,
            'customer_message' => $customer_message,
            'admin_users' => $admin_users,
            'customers' => $customers,
            'categories' => $categories,
            'total_qty' => $total_qty,
            'total_order' => $total_order,
            'paid_order' => $paid_order,
            'admin_received' => $admin_received]);
    }

    public function editProfile(){
        return view('contacts-edit-profile');
    }

    public function updateProfile(Request $request)
    {
        if(Auth::user()->email == $request->email){
            if($request->password!=''&&$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'avatar' => 'sometimes|image|mimes:jpg,jpeg,png|max:1024'
                ]);
            }else if($request->password==''&&$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'avatar' => 'sometimes|image|mimes:jpg,jpeg,png|max:1024'
                ]);
            }else if($request->password!=''&&!$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ]);
            }else{
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                ]);
            }
        }else{
            if($request->password!=''&&$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'avatar' => 'sometimes|image|mimes:jpg,jpeg,png|max:1024'
                ]);
            }else if($request->password==''&&$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'avatar' => 'sometimes|image|mimes:jpg,jpeg,png|max:1024'
                ]);
            }else if($request->password!=''&&!$request->hasFile('avatar')){
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                ]);
            }else{
                $validate = Validator::make($request->all(), [
                    'username' => 'required|string|max:255',
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                ]);
            }
        }

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors());
        }

        try{
            $user=Auth::user();
            $user->username = $request->username;
            if($request->password!=''){
                $user->password = Hash::make($request->password);
            }
            $user->email = $request->email;
            $user->name = $request->name;
            $user->company = $request->company;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->paypal_payout_email = $request->paypal_payout_email;

            if ($request->hasFile('avatar')) {
                $avataruloaded=request()->file('avatar');
                $avatarname= time().'.'.$avataruloaded->getClientOriginalExtension();
                $avatarpath= public_path('/images/');
                $avataruloaded->move($avatarpath,$avatarname);
                
                if($user->avatar !== NULL){
                    unlink(public_path( $user->avatar));
                }
                
                $user->avatar= '/images/'.$avatarname;
            }

            $user->save();
            return redirect()->to('dashboard');
        } catch(Exception $e){
            $error = "Oops! Something went wrong.";
            return redirect()->back()->with('error', $error); 
            // return redirect()->back()->with('error', $e->getMessage());  //-- display exception message
        }
    }

    public function saveCommissionFee(Request $request){
        $commission_fee = $request->commission_fee;
        $setup_config = Setup_config::where('type', 'commission_fee')->first();
        $setup_config->value = $commission_fee;
        $setup_config->save();
        return redirect()->to('dashboard');
    }

    public function saveCustomerMessage(Request $request){
        $message = $request->message;
        $setup_config = Setup_config::where('type', 'customer_message')->first();
        $setup_config->value = $message;
        $setup_config->save();
        echo 1;
    }

    public function checkCategory(Request $request){
        $id = $request->id;
        $category = Evr_category::find($id);
        $display = $category->display;
        if($display == "1"){
            $category->display = "0";
        }else{
            $category->display = "1";
        }
        $category->save();
        echo 1;
    }
}
