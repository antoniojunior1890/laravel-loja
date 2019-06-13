<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(Order $order, Purchase $purchase)
    {
        $paidOrdersDay = $order->getContpaidOrdersDay();
        $paidOrdersMonth = $order->getContpaidOrdersMonth();

        $purchasesDay = $purchase->getPurchasesDay();
        $purchasesMonth = $purchase->getPurchasesMonth();

        return view('admin.home.index',compact('paidOrdersDay','paidOrdersMonth','purchasesDay','purchasesMonth'));
    }

    public function salesMonth(Order $order)
    {
        return $order->getSalesMonth();
    }

    public function salesWeek(Order $order)
    {
        return $order->getSalesWeek();
    }

}
