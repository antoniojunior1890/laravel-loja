<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockRequest;
use App\Models\Category;
use App\Models\Stock;
use App\Repositories\StockRepository;

class StockController extends Controller
{
    protected $model;

    public function __construct(Stock $stock)
    {
        $this->model = new StockRepository($stock);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks =  $this->model->all();
        $count = $this->model->count();
        $total = $this->model->totalCount();

        return view ('admin.stock.index',compact('stocks','count','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id');

        return view ('admin.stock.create-edit',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {

        $response = $this->model->save($request);

        if($response['success'])
            return redirect()
                ->route('stock.index')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = $this->model->show($id);
        return view ('admin.stock.show',compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::pluck('name','id');
        $stock = $this->model->show($id);
        $product = $stock->product;

        return view ('admin.stock.create-edit',compact('categories','stock','product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        $response = $this->model->updated($request, $id);

        if($response['success'])
            return redirect()
                ->route('stock.index')
                ->with('success', $response['message']);

        return redirect()
            ->back()
            ->with('error', $response['message']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->model->delete($id);

        if($response['success'])
        {
            return redirect()
                ->route('stock.index')
                ->with('success', $response['message']);
        }
        else redirect()
            ->back()
            ->with('error', $response['message']);
    }
}
