<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartPurchase extends Model
{
    private $items = [];

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        if(Session::has('cartPurchase'))
        {
            $cart = Session::get('cartPurchase');

            $this->items = $cart->items;

        }
    }
    public function getItems()
    {
        return $this->items;
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

    public function emptyCart()
    {
        if(Session::has('cartPurchase'))
            Session::forget('cartPurchase');
    }

    public function removeProduct(Product $product)
    {
        if( isset($this->items[$product->id]) )
            unset($this->items[$product->id]);
    }

    public function savePurchase($request)
    {
        dd($request);
    }

}
