<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at','desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function update(Request $request)
    {
        dd($request);
    }

    public function update_status(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
        ]);

        return back();
    }
}
