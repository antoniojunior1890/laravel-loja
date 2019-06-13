<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    private $items = [];

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        if(Session::has('cart'))
        {
            $nameClient = Session::get('cart')->getNameClient();
            $orderId = Session::get('cart')->getIdOrder();


            $cart = Session::get('cart');

            $this->items = $cart->items;

            if($nameClient != "")
                $items[0] = ['order_id' => $orderId, 'order_name_client' =>  $nameClient];


//            dd( $items[0]);


//            dd( $items[0]['order_name_client']);
        }
    }

    public function constru($items)
    {
        $this->items = $items;
    }


    public function add(Product $product)
    {
        if( isset($this->items[$product->id]) )
            $this->items[$product->id] = [
                'item' => $product,
                'qtd' => $this->items[$product->id]['qtd'] + 1,
            ];
        else
            $this->items[$product->id] = [
                'item' => $product,
                'qtd' => 1,
            ];
    }

    public function remove(Product $product)
    {
        if( isset($this->items[$product->id]) && $this->items[$product->id]['qtd'] > 1 )
            $this->items[$product->id] = [
                'item' => $product,
                'qtd' => $this->items[$product->id]['qtd'] - 1,
            ];
        elseif( isset($this->items[$product->id]) )
            unset($this->items[$product->id]);
    }

    public function removeProduct(Product $product)
    {
        if( isset($this->items[$product->id]) )
            unset($this->items[$product->id]);
    }

    public function getItems()
    {
        return Arr::except($this->items, ['0']);
//        return $this->items;
    }

    public function total()
    {
        $total = 0;

        foreach ($this->items as $key => $item)
        {
            if($key != 0)
            {
//                dd($key );
                $subtotal = $item['item']->price * $item['qtd'];
                $total += $subtotal;

            }

        }

        return $total;
    }

    public function totalItems()
    {
        if(isset($this->items[0]))
            return count($this->items) - 1;
        return count($this->items);
    }

    public function emptyCart()
    {
        if(Session::has('cart'))
            Session::forget('cart');
    }

    public  function getNameClient()
    {
        if(isset($this->items[0]))
            return $this->items[0]['order_name_client'];
        return null;
    }

    public  function getIdOrder()
    {
        if(isset($this->items[0]))
            return $this->items[0]['order_id'];
        return null;
    }

}
