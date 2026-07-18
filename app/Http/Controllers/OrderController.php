<?php

namespace App\Http\Controllers;

use App\Events\OrderEvent;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;

class OrderController extends Controller
{

    public function index($limit = 4)
    {
        $orders = Order::with('order_items.foodItem')->where('user_id', Auth::user()->id)->latest()->orderBy('created_at', 'desc')->limit($limit)->get();

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

    public function create_order(Request $request)
    {
        $validate_request = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'payment_method' => 'required'
            ]
        );



        $cart = $this->getCart();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        $total = $this->calculateTotal($cart);

        if ($request->payment_method == 'online') {

            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );


            $paymentOrder = $api->order->create([
                'receipt' => 'ORD_' . time(),
                'amount' => $total * 100,
                'currency' => 'INR'
            ]);

            return response()->json([
                'status' => true,
                'payment' => true,
                'message' => 'Proceed to payment',
                'data' => [
                    'key' => config('services.razorpay.key'),
                    'order_id' => $paymentOrder['id'],
                    'amount' => $paymentOrder['amount'],
                    'currency' => $paymentOrder['currency'],
                ]
            ]);
        }

        DB::transaction(function () use ($request, $cart, $total) {

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'subtotal' => $total,
                'total' => $total
            ]);

            $this->createOrderItems($cart, $order);

            $cart->cartItems()->delete();
            $cart->delete();
        });
        return response()->json([
            'status' => true,
            'payment' => false,
            'message' => 'Order placed successfully.'
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
        $attributes = [
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature,
        ];

        try {
            //code...
            $api->utility->verifyPaymentSignature($attributes);
            if (Order::where('razorpay_payment_id', $request->razorpay_payment_id)->exists()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Order already created.',
                ]);
            }
            DB::transaction(function () use ($request) {

                $user_id = Auth::id();

                // Cart
                $cart = $this->getCart();

                if (!$cart) {
                    throw new \Exception("Cart is empty.");
                }

                // Total
                $total = $this->calculateTotal($cart);

                // Order Create
                $order = Order::create([
                    'user_id' => $user_id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,

                    'payment_method' => 'online',
                    'payment_status' => 'paid',

                    'subtotal' => $total,
                    'total' => $total,

                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ]);

                // Order Items
                $this->createOrderItems($cart, $order);

                // Cart Empty
                $cart->cartItems()->delete();
                $cart->delete();
                OrderEvent::dispatch($order);
            });

            return response()->json([
                'status' => true,
                'message' => 'Payment Verified & Order Placed Successfully'
            ]);
        } catch (\Throwable $e) {
            Log::error($e);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
        // Signature Verify
    }
    private function calculateTotal($cart)
    {
        return $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    private function getCart()
    {
        return Cart::with('cartItems')
            ->where('user_id', Auth::user()->id)
            ->first();
    }
    private function createOrderItems($cart, $order)
    {
        foreach ($cart->cartItems as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'food_item_id' => $item->food_item_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price,
            ]);
        }
    }
}
