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

    public function income($id)
    {           
            /* return $income = Movement::where('wallet_id',$id)
                ->where('type','i')
                ->get();   */  

                $categoryIncome= DB::table('movements')
                ->leftJoin('categories','movements.category_id','=','categories.id')
                ->where('movements.type','i')
                ->select('movements.value','categories.name')
                ->get();

                /*  $incomes = Movement::where('wallet_id',$id)
                ->where('type','i')
                ->get();
                foreach($incomes as $i){
                    $categoryValue=Category::where('category_id','=',$i->category_id)
                    ->where()
                }     
                 */
                return $categoryIncome;
    }
    public function expense($id)
    {           
            return $expenses = Movement::where('wallet_id',$id)
                ->where('type','e')
                ->get();            
    }
}
