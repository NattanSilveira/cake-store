<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CakeStoreRequest;
use App\Http\Requests\CakeUpdateRequest;
use App\Jobs\SendCakeAvailableMail;
use App\Models\Cake;
use Illuminate\Support\Facades\DB;

class CakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CakeStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CakeStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $cake = Cake::create([
                "nome" => $request->nome,
                "peso" => $request->peso,
                "qtd_disponivel" => $request->qtd_disponivel
            ]);

            if (!empty($request->interessados)) {
                foreach ($request->interessados as $item) {
                    $cake->waitingList()->create([
                        "email" => $item['email']
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'nook', 'msg' => 'Falha no cadastro']);
        }

        SendCakeAvailableMail::dispatch($cake)->onQueue('available-mail');

        return response()->json(['status' => 'ok', 'msg' => 'Cadastrado com sucesso!']);

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
    public function update(CakeUpdateRequest $request, $id)
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
