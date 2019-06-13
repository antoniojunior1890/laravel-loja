<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartPurchase;
use App\Models\Product;
use App\Models\Purchase;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $model;

    public function __construct(Purchase $purchase)
    {
        $this->model = new PurchaseRepository($purchase);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases =  $this->model->all();

//        dd($purchases[0]->products);
        return view ('admin.purchase.index',compact('purchases'));
    }

    public function products($id)
    {
        $purchase = $this->model->show($id);
        $products = $purchase->products;
        $totalPrice = $this->model->totalPrice($id);
        return view ('admin.purchase.products',compact('purchase','products','totalPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cart = new CartPurchase();

        $products = $cart->getItems();
        return view('admin.purchase.create-edit',compact('products'));
    }

    public function autocomplete(Request $request)
    {
        return $this->model->autocomplete($request);
    }

    public function addProductCartPurchase($id)
    {
        $response = $this->model->addProduct($id);

        if($response['success'])
            return redirect()
                ->route('purchases.create')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function removeProductCartPurchase($id)
    {
        $response =  $this->model->removeProduct($id);

        if($response['success'])
            return redirect()
                ->route('purchases.index')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function emptyPurchase()
    {
        $this->model->empty();

        return redirect()
            ->route('purchases.create')
            ->with('error', 'lista vazia');

    }

    public function removeProductPurchase($id)
    {
        $response = $this->model->removeProductPurchase($id);

        if($response['success'])
            return redirect()
                ->route('purchases.create')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }

    public function savePurchase(Request $request)
    {
        $response =  $this->model->savePurchase($request);

        if($response['success'])
            return redirect()
                ->route('purchases.index')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
