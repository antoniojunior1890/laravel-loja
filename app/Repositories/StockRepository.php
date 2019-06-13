<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 10/06/19
 * Time: 11:41
 */

namespace App\Repositories;


use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockRepository extends Repository
{
    public function count()
    {
        return $this->all()->count();
    }

    public function totalCount()
    {
        $stocks = $this->all();

        $total = 0;
        foreach ($stocks as $stock)
        {
            $total+= $stock->amount;
        }
        return $total;
    }

    public function delete($id)
    {

        $stock = $this->getModel()->find($id);

        $stock = $stock->product()->delete();

        if($stock)
        {
            return [
                'success'   => true,
                'message'   =>'Sucesso ao deletar'
            ];
        }else{
            return [
                'success'   => false,
                'message'   =>'Falha ao deletar'
            ];

        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function save($data)
    {


        $product = new Product();

        DB::beginTransaction();

        $product = $product->create([
            'category_id'   => $data->product['category_id'],
            'name'          => $data->product['name'],
            'description'   => $data->product['description'],
            'price'         => $data->product['price'],
        ]);

        $stock = $this->create(['amount' => $data->amount]);

        $stock = $product->stock()->save($stock);

        if($product && $stock)
        {
            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso ao adicionar'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao adicionar'
            ];


        }
    }


    public function updated($data, $id)
    {

        $stock = $this->getModel()->find($id);

        $product = Product::find($stock->product_id);


        DB::beginTransaction();

        $stock = $this->update(['amount' => $data->amount],$id);

        $product = $product->update([
            'category_id'   => $data->product['category_id'],
            'name'          => $data->product['name'],
            'description'   => $data->product['description'],
            'price'         => $data->product['price'],
        ]);

        if($product && $stock)
        {
            DB::commit();
            return [
                'success'   => true,
                'message'   =>'Sucesso ao salvar'
            ];
        }else{
            DB::rollBack();
            return [
                'success'   => false,
                'message'   =>'Falha ao salvar'
            ];


        }

    }
}