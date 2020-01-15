<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Wallet as WalletResource;
use Illuminate\Support\Facades\DB;

use App\Wallet;
use App\StoreWalletRequest;
use Hash;

class WalletControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return WalletResource::collection(Wallet::paginate(5));
        } else {
            return WalletResource::collection(Wallet::all());
        }
    }
    /* public function totalBalance(Request $request)
    {
        
        $totalBalance= DB::table('wallets')
        ->sum('balance') 
        ->get()        
        return $totalBalance;
    } */

    public function show($id)
    {
        return new WalletResource(Wallet::find($id));
    }

    public function store(Request $request)
    {
         $request->validate([
                'email' => 'required|email|unique:wallets,email',
                'balance'=> 'numeric'
            ]);
        $wallet = new Wallet();
        $wallet->fill($request->all());
        $wallet->save();
        return response()->json(new WalletResource($wallet), 201);
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'balance'=> 'numeric'
        ]);

        $wallet = Wallet::findOrFail($id);
        $wallet->update($request->all());
        
        return new WalletResource($wallet);
    }
}
