<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;


class ProductController extends AbstractController
{
    protected $model = Product::class;
    protected $path = 'admin.product';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $category = Category::pluck('name','id');
        return view ($this->path.'.create-edit',compact('category'));
    }

    public function edit($id)
    {
        $category = Category::pluck('name','id');
        $data = $this->getModel()->find($id);

        return view ($this->path.'.create-edit', compact('category','data'));
    }

    public function store(ProductRequest $request)
    {
        $data = Product::create($request->all());

        return redirect()
            ->route('product.index')
            ->with('success',' Produto Adicionado');


    }

    public function update(ProductRequest $request, $id)
    {

        $dada = Product::find($id);
        $dada->update($request->all());

        return redirect()
            ->route('product.index')
            ->with('success',' Produto Atualizado');

    }


}
