<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Order extends Model
{


    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsToMany(Product::class )->withPivot('qtd', 'price');
    }

//    public function newOrderProduct($nameClint, $cart, $status )
    public function newOrderProduct($name_client, $cart, $status, $payment_method )
    {
        $date = $payment_method ? date('Ymd') : null;

        DB::beginTransaction();

        $order = $this->create([
           'name_client'            => $name_client,
           'status'                 => $status,
           'payment_method'         => $payment_method,
           'date'                   => date('Ymd'),
           'date_refresh_status'    => $date,
        ]);

//        return $order;

        $productOrder = [];
        $itemsCart = $cart->getItems();



        if($status == 2)
        {
            $result = [];
            foreach ($itemsCart as $item)
            {
                $productOrder[$item['item']->id] = [
                    'qtd'   => $item['qtd'],
                    'price' => $item['item']->price,
                ];

                $stock = Stock::where('product_id',$item['item']->id)->first();

                $amount_stock = $stock->amount;

                $stock->amount = ($amount_stock - $item['qtd']);

                $result[] = $stock->save();

            }
        }else{
            foreach ($itemsCart as $item)
            {
                $productOrder[$item['item']->id] = [
                    'qtd'   => $item['qtd'],
                    'price' => $item['item']->price,
                ];
            }
        }


        if( $order)
        {

            $order->products()->attach($productOrder);

            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso salvar pedido'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao salvar pedido'
            ];


        }

    }

//    public function updateOrderProduct($name_client, $order_id, $cart)
    public function updateOrderProduct($name_client, $cart, $status, $payment_method)
    {

        $order_id = $cart->getIdOrder();

        $order = $this->find($order_id);

        if(!$order) {
            return [
                'success' => false,
                'message' => 'Ordem não encontrada'
            ];
        }

        DB::beginTransaction();

        $order->update([
            'name_client'           => $name_client,
            'status'                => $status,
            'payment_method'        => $payment_method,
            'date_refresh_status'   => date('Ymd'),
        ]);

//        return $result;

        $productOrder = [];
        $itemsCart = $cart->getItems();

//        dd($status);

        if($status == 2)
        {
            $result = [];
            foreach ($itemsCart as $item)
            {
                $productOrder[$item['item']->id] = [
                    'qtd'   => $item['qtd'],
                    'price' => $item['item']->price,
                ];

                $stock = Stock::where('product_id',$item['item']->id)->first();

                $amount_stock = $stock->amount;

                $stock->amount = ($amount_stock - $item['qtd']);

                $result[] = $stock->save();

            }
        }else {

            foreach ($itemsCart as $item) {
                $productOrder[$item['item']->id] = [
                    'qtd' => $item['qtd'],
                    'price' => $item['item']->price,
                ];
            }
        }
//        return dd($productOrder);
        if( $order)
        {

            $order->products()->sync($productOrder);

            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso salvar pedido'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao salvar pedido'
            ];


        }


    }

    public function getStatus($status)
    {
        $statusArray = [
            1 => 'Aguardando Pagamento',
            2 => 'Pago',
            3 => 'Cancelado',
        ];

        return $statusArray[$status];
    }

    public function getPaymentMethod($paymentMethod)
    {
        $paymentMethodArray = [
            1 => 'Avista',
            2 => 'Boleto',
            3 => 'Cartão',
        ];

        return $paymentMethodArray[$paymentMethod];
    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getDateRefreshStatusAttribute($value)
    {
        if($value == null)
            return "-";

        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getPaidOrders()
    {
        return $this->where('status',2)->get();
    }

    public function getContpaidOrdersDay()
    {
        return $this->whereDay('date',date('d'))
                    ->where('status',2)
                    ->count();
    }

    public function getContpaidOrdersMonth()
    {
        return $this->whereMonth('date',date('m'))
            ->where('status',2)
            ->count();
    }

    public function getSales()
    {

        $orders = $this
            ->select(DB::raw('count(*) as qt, date'))
            ->whereMonth('date',date('m'))
            ->groupBy('date')
            ->get();

//        dd(intval(Carbon::parse($orders[0]->date)->format('d')));

//        dd($orders[0]->qt);
//        dd($orders[0]->date);
//        $array = [
//            "foo" => "bar",
//            "bar" => "foo",
//        ];
        $array  = [];

        foreach ($orders as $order)
        {
            $i = intval(Carbon::parse($order->date)->format('d'));

            $array[$i] = $order->qt;
        }

//        dd($array[5]);


        $arrayQt = [];
        for ($i = 1; $i <= date('d'); $i++) {
            if(isset($array[$i])){
                $arrayQt[$i] = $array[$i];
            }else{
                $arrayQt[$i] = 0;
            }
        }

//        dd($arrayQt);

        return $arrayQt;
//        dd($array);
//        $result = $this->whereMonth('date',date('m'))
//            ->where('status',2)->get();

    }


    public function getTotalOrder()
    {
        $products = $this->products;

        $total = 0;

//        dd($this->products());
//        dd($products[0]->pivot->price);

        foreach ($products as $product)
        {
            $subtotal = $product->pivot->price * $product->pivot->qtd;
            $total += $subtotal;
        }

//        dd($total);
        return $total;
    }
}
