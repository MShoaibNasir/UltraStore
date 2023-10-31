<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Order;
use App\Transaction;
use DB;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Razorpay\Api\Api;
use Stripe;

class GatewayController extends Controller {
	private $theme;

	public function __construct() {
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');

		$this->theme = env('ACTIVE_THEME', 'default');
		date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
	}

	public function confirm_order($type, $order_id) {
		$order_id = decrypt($order_id);
		$order = Order::find($order_id);

		if (!$order) {
			abort(404);
		}

		if ($order->transaction()->exists()) {
			return redirect('/')->with('error', _lang('Sorry, Payment has already made for this order !'));
		}

		if ($order->status == $order::PENDING_PAYMENT) {
			//Update Order Status
			$order->status = $order::PENDING;
			$order->payment_method = $type == 'cod' ? 'Cash_On_Delivery' : 'Bank_Transfer';
			$order->save();

			//Trigger Order Palced Event
			event(new \App\Events\OrderPlaced($order));

			return view("theme.$this->theme.order-complete", compact('order'));
		}

		return redirect('/');

	}

	public function paypal_payment_authorize($paypalOrderId, $order_id) {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);

		$order = Order::find($order_id);

		// Creating an environment
		$clientId = get_option('paypal_client_id');
		$clientSecret = get_option('paypal_secret');

		if (get_option('paypal_mode') != 'production') {
			$environment = new SandboxEnvironment($clientId, $clientSecret);
		} else {
			$environment = new ProductionEnvironment($clientId, $clientSecret);
		}

		$client = new PayPalHttpClient($environment);

		$request = new OrdersCaptureRequest($paypalOrderId);
		$request->prefer('return=representation');

		try {
			$response = $client->execute($request);

			if ($response->result->status == 'COMPLETED') {

				//dd($response);

				DB::beginTransaction();

				$amount = $response->result->purchase_units[0]->amount->value;

				//Create Transaction
				$transaction = new Transaction();
				$transaction->order_id = $order_id;
				$transaction->transaction_id = $response->result->id;
				$transaction->payment_method = 'PayPal';
				$transaction->amount = $amount;

				$transaction->save();

				//Update Order Status
				$order->status = $order::PENDING;
				$order->payment_method = 'PayPal';
				$order->save();

				//Trigger Order Palced Event
				event(new \App\Events\OrderPlaced($order));

				DB::commit();

				return view("theme.$this->theme.order-complete", compact('order'));
			}

		} catch (HttpException $ex) {
			return back()->with('error', _lang('Sorry, Payment not completed, Please contact with your administrator !'));
		}
	}

	public function stripe_payment_authorize(Request $request, $order_id) {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);

		$order = Order::find($order_id);

		if ($order->transaction()->exists()) {
			return redirect('/')->with('error', _lang('Sorry, Payment has already made for this order !'));
		}

		Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));
		$charge = Stripe\Charge::create([
			"amount" => convert_currency_2(1, $order->currency_rate, round($order->total * 100)),
			"currency" => $order->currency,
			"source" => $request->stripeToken,
			"description" => _lang('E-Commerce Purchase'),
		]);

		// Retrieve Charge Details
		if ($charge->amount_refunded == 0 && $charge->failure_code == null && $charge->paid == true && $charge->captured == true) {

			$amount = $charge->amount / 100;

			DB::beginTransaction();

			//Create Transaction
			$transaction = new Transaction();
			$transaction->order_id = $order_id;
			$transaction->transaction_id = $charge->id;
			$transaction->payment_method = 'Stripe';
			$transaction->amount = $amount;

			$transaction->save();

			//Update Order Status
			$order->status = $order::PENDING;
			$order->payment_method = 'Stripe';
			$order->save();

			//Trigger Order Palced Event
			event(new \App\Events\OrderPlaced($order));

			DB::commit();

			return view("theme.$this->theme.order-complete", compact('order'));
		} else {
			return back()->with('error', _lang('Sorry, Payment not completed, Please contact with your administrator !'));
		}
	}

	public function razorpay_payment_authorize(Request $request, $order_id) {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);

		$order = Order::find($order_id);

		if ($order->transaction()->exists()) {
			return redirect('/')->with('error', _lang('Sorry, Payment has already made for this order !'));
		}

		$api = new Api(get_option('razorpay_key_id'), get_option('razorpay_key_secret'));

		//Create Order
		$orderData = [
			'receipt' => $order->id,
			'amount' => convert_currency_2(1, $order->currency_rate, ($order->total * 100)),
			'currency' => $order->currency,
			'payment_capture' => 1, // auto capture
		];

		$razorpayOrder = $api->order->create($orderData);
		$razorpayOrderId = $razorpayOrder['id'];

		try {

			$charge = $api->payment->fetch($_POST['razorpay_payment_id']);
			$charge->capture(array('amount' => $charge->amount, 'currency' => $order->currency));

			$amount = $charge->amount / 100;

			DB::beginTransaction();

			//Create Transaction
			$transaction = new Transaction();
			$transaction->order_id = $order_id;
			$transaction->transaction_id = $charge->id;
			$transaction->payment_method = 'Razorpay';
			$transaction->amount = $amount;

			$transaction->save();

			//Update Order Status
			$order->status = $order::PENDING;
			$order->payment_method = 'Razorpay';
			$order->save();

			//Trigger Order Palced Event
			event(new \App\Events\OrderPlaced($order));

			DB::commit();

			return view("theme.$this->theme.order-complete", compact('order'));
		} catch (\Exception $e) {
			return back()->with('error', _lang('Sorry, Payment not completed !'));
		}
	}

	public function paystack_payment_authorize(Request $request, $order_id, $reference) {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);

		$order = Order::find($order_id);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . get_option('paystack_secret_key'),
				"Cache-Control: no-cache",
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
			return back()->with('error', $err);
		}

		$charge = json_decode($response);

		DB::beginTransaction();

		//Create Transaction
		$transaction = new Transaction();
		$transaction->order_id = $order_id;
		$transaction->transaction_id = $charge->data->id;
		$transaction->payment_method = 'Paystack';
		$transaction->amount = $charge->data->amount / 100;

		$transaction->save();

		//Update Order Status
		$order->status = $order::PENDING;
		$order->payment_method = 'Paystack';
		$order->save();

		//Trigger Order Palced Event
		event(new \App\Events\OrderPlaced($order));

		DB::commit();

		return view("theme.$this->theme.order-complete", compact('order'));
	}

}