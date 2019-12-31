<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Movement as MovementResource;
use Illuminate\Support\Facades\DB;

use App\Movement;
use App\StoreUserRequest;
use Carbon\Carbon;

class MovementControllerAPI extends Controller
{
    public function index(Request $request)
    {
            return MovementResource::collection(Movement::paginate(10));
    }

    public function show($id)
    {
        return new MovementResource(Movement::find($id));
    }

    public function show_movement_id($id)
    {
        return MovementResource::collection(Movement::where('wallet_id', $id)->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required',
            'type' => 'required',
            'transfer' => 'required',
            'value' => 'required',
            'start_balance' => 'required',
            'end_balance' => 'required'
        ]);

        $movement = new Movement();
        $movement->fill($request->all());
        $movement->date = (Carbon::now()->toDateTimeString());

        $movement->save();
        return response()->json(new MovementResource($movement), 201);
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'wallet_id' => 'required',
            'type' => 'required',
            'transfer' => 'required',
            'value' => 'required',
            'start_balance' => 'required',
            'end_balance' => 'required'
        ]);

        $movement = Movement::findOrFail($id);

        $movement->update($request->all());
        return new MovementResource($movement);
    }
}
