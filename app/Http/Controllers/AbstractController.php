<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbstractController extends Controller
{

    protected $model_instance;

    /**
     * Mostra uma lista de registros
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->getModel()->all();

        $quant = $data->count();
        $total = 0;
        foreach ($data as $d)
        {
            $total += $d->amount;
        }

//        dd($total);

        return view ($this->path.'.index', compact('data','quant','total'));
//        return view ($this->path.'.index', ['data'=>$data]);
    }
    /**
     * Exibe um formulário de criação de registro
     *
     * @return Response
     */
    public function create()
    {
        return view ($this->path.'.create-edit');
    }

    /**
     * Exibe um formulário de edição de registros
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->getModel()->find($id);

        return view ($this->path.'.create-edit', ['data'=>$data]);
    }
//    public function edit($id)
//    {
//        $data = $this->getModel()->find($id);
//        return view ($this->path.'.edit', ['data'=>$data]);
//    }

    /**
     * Armazena um novo registro
     *
     * @param Request $request
     * @return Response
     */
//    public function store(Request $request)
//    {
//        $data = $this->getModel()->create($request->all());
//        return redirect()->route($this->path.'.create')->with('data',$data);;
//    }
    /**
     * Exibe um registro específico
     ** @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->getModel()->find($id);
        return view ($this->path.'.show', ['data'=>$data]);
    }

    /**
     * Atualiza um registro específico
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
//    public function update(Request $request, $id)
//    {
//        $data = $this->getModel()->find($id);
//        $data->update($request->all());
//        return redirect()->route($this->path.'.index');
//    }
    /**
     * Remove um registro específico
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
//        $dataRemove = $this->getModel()->find($id);
//        $dataRemove->delete();
//        dd($id);

        $this->getModel()->destroy($id);

        $data = $this->getModel()->all();
        return view ($this->path.'.index', ['data'=>$data]);

//        $this->index();

//        return redirect()->route($this->path.'.index');


    }

    public function buscaid($id)
    {
        $data = $this->getModel()->find($id);
        return $data;
    }

    protected function getModel()
    {
        if ($this->model_instance === null)
            $this->model_instance = new $this->model;
        return $this->model_instance;
    }

}
