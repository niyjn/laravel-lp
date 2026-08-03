<?php

namespace App\Http\Controllers;

use App\Models\extrato;
use Illuminate\Http\Request;

class ExtratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'id_pedido' => 'required|int',
            'descricao' => 'required|string|max:255'
        ]);

        $endereco = Endereco::create([
            'id_pedido' => $dados['id_pedido'],
            'descricao' => $dados['descricao']
        ]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(extrato $extrato)
    {
        return view('extrato.show', compact('extrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(extrato $extrato)
    {
        return view('extrato.edit', compact('extrato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, extrato $extrato)
    {
        $dados = $request->validate([
            'id_pedido' => 'required|int',
            'descricao' => 'required|string|max:255'
        ]);

        $extrato->update($dados);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(extrato $extrato)
    {
        $extrato->delete();

        return redirect()->back();
    }
}
