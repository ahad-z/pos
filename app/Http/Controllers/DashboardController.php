<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function customerCount()
    {
        return $total_customer = User::count();
    }

    public function todaySell()
    {
        return $today_sell = Order::whereDate('created_at', now())->sum('total');
    }

     public function todayDue()
    {
        return $today_due = Order::whereDate('created_at', now())->sum('due');
    }

    public function MonthlySell()
    {
        return $today_due = Order::whereMonth('created_at', now()->month)->sum('total');
    }
}
