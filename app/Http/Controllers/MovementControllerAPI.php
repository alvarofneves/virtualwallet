<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Movement as MovementResource;
use Illuminate\Support\Facades\DB;

use App\Movement;
use App\StoreUserRequest;
use Hash;

class MovementControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return MovementResource::collection(Movement::paginate(5));
        } else {
            return MovementResource::collection(Movement::all());
        }


    }

    public function show($id)
    {
        return new MovementResource(Movement::find($id));
    }

    public function show_movement_id($id)
    {
        return MovementResource::collection(Movement::where('wallet_id', $id)->get());
    }

    public function store(Request $request)
    {
      /*   $request->validate([
                'email' => 'required|email|unique:users,email',
                ''
                
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);*/
    }
 
    /* public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,'.$id,
                //'type' => 'enum('u','o','a')'
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    } */
}
