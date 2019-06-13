<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function saveOrder(Order $order, Request $request)
    {
//        return dd($request->all());

        $name_client = $request->name_client;
        $payment_method = $request->payment_method;
        $status = $request->status;


        $cart = new Cart;
        $idOrder = $cart->getIdOrder();


        if($idOrder)
        {
//            $order->updateOrderProduct($name_client, $idOrder, $cart);
            $order->updateOrderProduct($name_client, $cart, $status, $payment_method);
        }else{
            $order->newOrderProduct($name_client, $cart, $status, $payment_method);
        }



//        dd($cart);

        $cart->emptyCart();

//        return redirect()->route('orders');
        return redirect()->route('cart');
    }

    public function orders(Order $order)
    {
        $orders = $order->where('status',1)->get();

        return view('admin.order.open',compact('orders'));
    }

    public function paidOrders(Order $order)
    {
        $orders = $order->getPaidOrders();

        return view('admin.order.paid',compact('orders'));
    }

    public function detailsOrder(Order $order,$id)
    {
        $order = $order->where('id',$id)->get()->first();
        if(!$order)
            return redirect()->back();

//        $products = $order->products()-get();
        $products = $order->products;

//        dd($order->getTotalOrder());

        return view('admin.order.details',compact('order','products'));
    }

    public function payOrderExisting(Request $request, Order $order,$id)
    {
        $payment_method = $request->payment_method;
        $order = $order->find($id);


        if(!$order)
        {
            return [
                'success' => false,
                'message' => 'Falha ao salvar'
            ];
        }

        DB::beginTransaction();

        $productsOrder = $order->products;

        $result=[];
        foreach ($productsOrder as $product)
        {
            $stock = Stock::where('product_id',$product->id)->first();

            $amount_stock = $stock->amount;

            $stock->amount = ($amount_stock - $product->pivot->qtd);


//            dd($stock);
            $result[] = $stock->save();
        }


        $resultOrder = $order->update([
            'status'                 => DB::raw(2),
            'payment_method'         => DB::raw($payment_method),
            'date_refresh_status'    => date('Ymd'),
        ]);

        if(!in_array(false,$result) && $resultOrder)
        {

            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso realizar compra'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao realizar compra'
            ];


        }

//        dd($result);
        if($result)
            return redirect()->back()->with('success', 'Operação realizada com sucesso');
        else
            return redirect()->back()->with('error', 'Falha ao realizar operação.');

    }


}
