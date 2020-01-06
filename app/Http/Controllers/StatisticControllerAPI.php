<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\Movement as MovementResource;
use Illuminate\Support\Facades\DB;

use App\Movement;
use App\Category;
use App\User;
use App\StoreUserRequest;
use Carbon\Carbon;

class StatisticControllerAPI extends Controller
{
    public function index(Request $request)
    {
        return MovementResource::collection(Movement::orderBy('date','DESC')->paginate(10));
    }

    public function income(Request $request, $id)
    {
        $request->from = Carbon::createFromFormat('Y-m-d', $request->from)->format('Y-m-d H:i:s');
        $request->to = Carbon::createFromFormat('Y-m-d', $request->to)->format('Y-m-d H:i:s');

        $categoryIncome= DB::table('movements')
        ->leftJoin('categories','movements.category_id','=','categories.id')
        ->where('movements.type','i')
        ->where('wallet_id', $id)
        ->whereBetween('movements.date',[date($request->from), date($request->to)])
        ->select('movements.value','categories.name','movements.date')
        ->get();
                
        return $categoryIncome;
    }
    
    public function expense(Request $request, $id)
    {
        $request->from = Carbon::createFromFormat('Y-m-d', $request->from)->format('Y-m-d H:i:s');
        $request->to = Carbon::createFromFormat('Y-m-d', $request->to)->format('Y-m-d H:i:s');

        $categoryExpense= DB::table('movements')
        ->leftJoin('categories','movements.category_id','=','categories.id')
        ->where('movements.type','e')
        ->where('wallet_id', $id)
        ->whereBetween('movements.date',[date($request->from), date($request->to)])
        ->select('movements.value','categories.name','movements.date')
        ->get();
                
        return $categoryExpense;
    }
}
