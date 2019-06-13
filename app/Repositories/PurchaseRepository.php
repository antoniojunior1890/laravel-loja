<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 10/06/19
 * Time: 17:49
 */

namespace App\Repositories;


use App\Http\Requests\StockRequest;
use App\Models\CartPurchase;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PurchaseRepository extends Repository
{
    public function totalPrice($id)
    {
        $products = $this->show($id)->products;

        $total = 0;
        foreach ($products as $product)
        {
            $subtotal = $product->pivot->price * $product->pivot->qtd;
            $total += $subtotal;
        }

        return $total;
    }

    public function autocomplete($request)
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

    public function addProduct($id)
    {
        $product = Product::find($id);
        if( !$product )
            return null;

        $cart = new CartPurchase();
        $cart->add($product);

        Session::put('cartPurchase', $cart);

        return $cart;
    }

    public function removeProduct($id)
    {
        $product = Product::find($id);
        if( !$product )
            return null;

        $cart = new CartPurchase();
        $cart->remove($product);

        Session::put('cartPurchase', $cart);

        return $cart;
    }

    public function empty()
    {
        $cart = new CartPurchase();
        $cart->emptyCart();
    }

    public function removeProductPurchase($id)
    {
        $product = Product::find($id);
        if( !$product ) {
            return [
                'success' => false,
                'message' => 'Falha ao deletar'
            ];
        }

        $cart = new CartPurchase();
        $cart->removeProduct($product);

        Session::put('cartPurchase', $cart);

        return [
            'success'   => true,
            'message'   =>'Sucesso ao deletar'
        ];

    }

    public function savePurchase($request)
    {
        $cart = new CartPurchase();
        $itemsCart = $cart->getItems();


        if(!$itemsCart)
        {
            return [
                'success' => false,
                'message' => 'Falha ao salvar'
            ];
        }

        DB::beginTransaction();

        $resultPurchase = $purchase = $this->create([
            'name_salesman'  => $request->name_salesman,
            'status'                 => 1,
            'payment_method'         => 1,
            'date'                   => date('Ymd'),
        ]);

        $result=[];

        $productCartPurchase = [];
        foreach ($itemsCart as $item)
        {
            $productCartPurchase[$item['item']->id] = [
                'qtd'   => $item['qtd'],
                'price' => $item['item']->price,
            ];

            $stock = Stock::where('product_id',$item['item']->id)->first();


            $amount_stock = $stock->amount;

            $stock->amount = (intval($item['qtd']) + $amount_stock);

            $result[] = $stock->save();

        }

        $purchase->products()->attach($productCartPurchase);

        if(!in_array(false,$result) && $resultPurchase)
        {

            $this->empty();

            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso ao Salvar'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao Salvar'
            ];


        }
    }

}