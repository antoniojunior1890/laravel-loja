<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;


class CategoryController extends AbstractController
{
    protected $model = Category::class;
    protected $path = 'admin.category';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(CategoryRequest $request)
    {

        $data = Category::create($request->all());

        return redirect()
            ->route('category.index', compact($data))
            ->with('success',' Categoria Adicionada');


    }

    public function update(CategoryRequest $request, $id)
    {

        $data = Category::find($id);
        $data->update($request->all());

        return redirect()
            ->route('category.index', compact($data))
            ->with('success',' Categoria Atualizada');

    }

}
