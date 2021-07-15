<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Customer;
use App\Setup_config;
use App\Evr_event;
use App\Evr_cost;
use App\Evr_attendee;
use App\Evr_category;
use Str;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Currency;

class CustomerController extends Controller
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

    public function __construct()
    {
            
        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function index(Request $request)
    {
        $id=$request->id;
        $customers = Customer::where('admin_id', $id)->get();
        $original_url = url('customers/registration')."/".Auth::user()->id;
        $short = $original_url;
        if(Auth::user()->is_admin != 1){
            $custom_alias = Str::random(5);
            $url = 'http://gogunclass.com/api/?key=uCYh6bGxWfDc&url='.$original_url.'&custom='.$custom_alias;
            //Use file_get_contents to GET the URL in question.
            $contents = file_get_contents($url);        
            $result = json_decode($contents, true);
            if($result['error'] == 0){
                $short = $result['short'];
            }
        }
        return view('customers', ['customers' => $customers, 'url' => $short]);
    }

    public function register($id){
        $categories = Evr_category::where('display', '1')->get();
        $user = User::find($id);
        return view('customer-registration', ['categories' => $categories, 'user' => $user]);
    }

    public function select_class_date(Request $request){
        $location = $request->location;
        $category = '"'.$location.'"';
        $events = Evr_event::where('category_id', 'like', "%$category%")->where('reg_limit', '>', 0)->where('end_year', '>=', date("Y"))->where('end_month', '>=', date("n"))->where('end_day', '>=', date("j"))->orderBy('start_year', 'asc')->orderBy('start_month', 'asc')->orderBy('start_day', 'asc')->get();
        $dates = array();
        foreach($events as $event){
            $start_date = $event -> start_date;
            $end_date = $event -> end_date;
            for($date = $start_date;strtotime($date)<=strtotime($end_date); $date = date("Y-n-j", strtotime("+1 day", strtotime($date)))){
                if(strtotime($date)>=strtotime(date("Y-n-j")))
                    $dates[] = $date;
            }
        }
        return view('select-class-date', ['dates' => $dates]);
    }

    public function select_qty(Request $request){
        $location = $request->location;
        $date = $request->date;
        $category = '"'.$location.'"';
        $event = Evr_event::where('category_id', 'like', "%$category%")->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first();
        $event_id = $event->id;
        $price = Evr_cost::where('event_id', $event_id)->where('item_title', 'Admission')->first();
        if($price == null)
            $price="40.00";
        else
            $price = $price->item_price;
        $qty = $event->reg_limit;
        return view('registration-fee', ['price' => $price, 'qty' => $qty]);
    }

    public function save(Request $request){
        $fname=$request->firstname;
        $lname=$request->lastname;
        $email=$request->email;
        $phone=$request->phone;
        $address=$request->address;
        $city=$request->city;
        $state=$request->state;
        $zip=$request->zip;
        $location=$request->location;
        $date=$request->class_date;
        $category = '"'.$location.'"';
        $event_id = Evr_event::where('category_id', 'like', "%$category%")->where('start_date', '<=', $date)->where('end_date', '>=', $date)->first()->id;
        $qty=$request->QTY;
        $total=$request->total;
        $discount = $request->discount;
        $attendee_id = DB::connection('mysql2')->table('evr_attendee')->insertGetId([
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'event_id' => $event_id,
            'date' => $date,
            'quantity' => $qty,
            'order_total' => $total,
            'discount_percentage' => $discount,
            'discount_amount' => $discount
        ]);
        $customer = new Customer;
        $customer->fname = $fname;
        $customer->lname = $lname;
        $customer->attendee_id = $attendee_id;
        $customer->admin_id = $request->id;
        $customer->save();
        $attendee = Evr_attendee::find($attendee_id);
        $event = Evr_event::find($event_id);
        if($event == null)
            $event_name = "Concealed Certification Course";
        else
            $event_name = $event->event_name;
        $customer_message = Setup_config::where('type', 'customer_message')->first()->value;
        return view('customer-confirmation', ['attendee' => $attendee, 'event_name' => $event_name, 'customer_message' => $customer_message]);
    }

    public function confirm(Request $request){
        $attendee_id = $request->attendee_id;
        $attendee = Evr_attendee::find($attendee_id);
        $customer = Customer::where('attendee_id', $attendee_id)->first();
        $event = Evr_event::find($attendee->event_id);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName($event->event_name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($attendee->order_total);

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($attendee->order_total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Enter Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl('https://firearmtrainingpro.com/affiliate5/public/customers/payout')
            ->setCancelUrl('https://firearmtrainingpro.com/affiliate5/public/customers/payout');

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));            
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return view('payment-confirmation', ['id' => $customer->admin_id]);
            } else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return view('payment-confirmation', ['id' => $customer->admin_id]);
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('paypal_payment_id', $payment->getId());
        Session::put('attendee_id', $attendee_id);

        if(isset($redirect_url)) {            
            return redirect()->to($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
        return view('payment-confirmation', ['id' => $customer->admin_id]);
    }

    public function payout(Request $request){
        $payment_id = Session::get('paypal_payment_id');
        $attendee_id = Session::get('attendee_id');
        $attendee = Evr_attendee::find($attendee_id);
        $customer = Customer::where('attendee_id', $attendee_id)->first();
        Session::forget('paypal_payment_id');
        Session::forget('attendee_id');
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error','Payment failed');
            return view('payment-confirmation', ['id' => $customer->admin_id]);
        }
        $payment = Payment::get($payment_id, $this->_api_context);        
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        
        $result = $payment->execute($execution, $this->_api_context);
        
        if ($result->getState() == 'approved') {         
            \Session::put('success','Payment success !!');
            $attendee = Evr_attendee::find($attendee_id);
            $attendee->payment = $attendee->order_total;
            $attendee->payment_status = "success";
            $attendee->amount_pd = $attendee->order_total;
            $attendee->payment_date = date("Y-m-d H:i:s");
            $attendee->token = $request->input('token');
            $attendee->save();
            $data['attendee'] = $attendee;
            $event = Evr_event::find($data['attendee']->event_id);
            $event->reg_limit = $event->reg_limit-$attendee->quantity;
            $event->save();
            $data['event'] = $event;
            $admin_email = User::where('is_admin', 1)->first()->email;
            $admin_user = User::find($customer->admin_id);
            $data['admin_user'] = $admin_user;
            $payout = Setup_config::where('type', 'payout')->first();
            $payout_status = '0';
            if($payout != null){
                $payout_status = $payout->value;
            }
            if($payout_status == '1'){
                $payouts = new Payout();
                $senderBatchHeader = new PayoutSenderBatchHeader();
                $senderBatchHeader->setSenderBatchId(uniqid())
                    ->setEmailSubject("You have a Payout!");
                $amount = new Currency();
                $amount->setCurrency('USD')
                    ->setValue($attendee->quantity*$admin_user->commission_fee);
                $senderItem = new PayoutItem();
                $senderItem->setRecipientType('Email')
                    ->setNote('Thanks for your patronage!')
                    ->setReceiver($admin_user->paypal_payout_email)
                    ->setSenderItemId(date("u"))
                    ->setAmount($amount);    
                $payouts->setSenderBatchHeader($senderBatchHeader)
                    ->addItem($senderItem);    
                try {
                    $output = $payouts->create(array('sync_mode' => 'false'), $this->_api_context);
                    $user_email = $admin_user->email;
                    Mail::send('email.user_email', compact('data'), function ($message) use ($user_email) {
                        $message->from('support@firearmtrainingpro.com', "Firearm Training Pro");
                        $message->subject('Order Details');
                        $message->to($user_email);
                    });
                } catch (\Exception $e) {
                    \Session::put('error',$e->getMessage());
                }
            }else{
                $mannual_fee = $admin_user->commission;
                $mannual_fee += $attendee->quantity*$admin_user->commission_fee;
                $admin_user->commission = $mannual_fee;
                $admin_user->save();
            }
            Mail::send('email.admin_email', compact('data'), function ($message) use ($admin_email) {
                $message->from('support@firearmtrainingpro.com', "Firearm Training Pro");
                $message->subject('Order Details');
                $message->to($admin_email);
            });
            
            $customer_email = $data['attendee']->email;
            Mail::send('email.user_email', compact('data'), function ($message) use ($customer_email) {
                $message->from('support@firearmtrainingpro.com', "Firearm Training Pro");
                $message->subject('Order Details');
                $message->to($customer_email);
            });
            return view('payment-confirmation', ['id' => $customer->admin_id]);
        }else{
            \Session::put('error','Payment failed !!');
            $attendee = Evr_attendee::find($attendee_id);
            $attendee->payment = $attendee->order_total;
            $attendee->payment_status = "failed";
            $attendee->amount_pd = 0;
            $attendee->payment_date = date("Y-m-d H:i:s");
            $attendee->token = $request->input('token');
            $attendee->save();            
            return view('payment-confirmation', ['id' => $customer->admin_id]);
        }
    }
    
    public function checkout(Request $request){
        $value = $request->amount;
        $receiver = $request->payeer;
        $payouts = new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a Payout!");
        $amount = new Currency();
        $amount->setCurrency('USD')
            ->setValue($value);
        $senderItem = new PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks for your patronage!')
            ->setReceiver($receiver)
            ->setSenderItemId(date("u"))
            ->setAmount($amount);    
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);    
        try {
            $output = $payouts->create(array('sync_mode' => 'false'), $this->_api_context);
            echo "success";
            echo "<br>";
            var_dump($output);
        } catch (\Exception $e) {
            var_dump('error',$e->getMessage());
        }
    }
}
