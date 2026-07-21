<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'users' => User::where('role','customer')->count(),
            'orders' => Order::count(),
            'revenue' => Order::sum('total'),
            'foods' => FoodItem::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function monthly_orders()
    {
        $monthly_orders = Order::selectRaw("MONTH(created_at) as month,COUNT(*) as total")->groupByRaw("MONTH(created_at)")->orderByRaw("MONTH(created_at)")->get();

        $months = collect(range(1, 12))->map(function ($month) use ($monthly_orders) {
            $order = $monthly_orders->firstWhere('month', $month);

            return [
                'month' => date('M', mktime(0, 0, 0, $month, 1)),
                'total' => $order ? $order->total : 0,
            ];
        });
        return response()->json([
            'status'=>true,
            'monthly_orders'=>$months
        ]);
    }
}
