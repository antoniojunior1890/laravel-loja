<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function cart()
    {
        $cart = new Cart();

        $products = $cart->getItems();


//        dd($products);

        return view('admin.cart.cart',compact('cart', 'products'));
    }

    public function autocomplete(Request $request)
    {

        $query = $request->input('term','');

        $data = Product::select("id","name")
            ->where("name","LIKE","%{$query}%")
            ->orWhere('id',$query)
            ->get();

        $array = array();
        foreach ($data as $d) {
            $array[] = array('label' => $d->name, 'id' => $d->id,'value' => $d->name);
        }

        return json_encode($array);
    }

    public function add($id)
    {
        $product = Product::find($id);
        if( !$product )
            return redirect()->back();

        $cart = new Cart;
        $cart->add($product);

        Session::put('cart', $cart);

//        dd($cart);
        return redirect()->route('cart');
    }

    public function remove($id)
    {
        $product = Product::find($id);
        if( !$product )
            return redirect()->back();

        $cart = new Cart;
        $cart->remove($product);

        Session::put('cart', $cart);

//        dd($cart);
        return redirect()->route('cart');
    }

    public function empty()
    {
        $cart = new Cart;
        $cart->emptyCart();

        return redirect()->route('cart');
    }

    public function removeProduct($id)
    {
        $product = Product::find($id);
        if( !$product )
            return redirect()->back();

        $cart = new Cart;
        $cart->removeProduct($product);

        Session::put('cart', $cart);

        return redirect()->route('cart');
    }

    public function cartTeste(Order $order, $id)
    {
        $order = $order->where('id',$id)->get()->first();

        if(!$order)
            return redirect()->back();

        if(Session::has('cart'))
            Session::forget('cart');

//        $products = [];
//        dd($order->products[0]->pivot->qtd);
        $productsOrder = $order->products;

//        dd($products);
//        dd($products[0]->pivot->qtd);



//        $cart = $products;



        $items = [];
        foreach ($productsOrder as $productOrder)
        {
            $items[$productOrder->id] = [
                'item' => $productOrder,
                'qtd' => $productOrder->pivot->qtd,
            ];

//            $cart->add($productOrder);
//
//            Session::put('cart', $cart);
        }

        $items[0] = ['order_id' => $order->id, 'order_name_client' =>  $order->name_client];
        $cart = new Cart;
        $cart->constru($items);
        Session::put('cart', $cart);


//        dd($cart);
        $products = $cart->getItems();

//        foreach ($products as $product)
//        {
//            dd($product['item']->stock->amount);
//        }
//        $name_client = $order->name_client;

        return view('admin.cart.cart',compact('cart', 'products', 'order'));


    }
}
