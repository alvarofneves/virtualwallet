<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;

use App\User;
use App\StoreUserRequest;
use Hash;

class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {
            return UserResource::collection(User::all());
        }
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function me()
    {
        dd(auth()->guard('api')->user());
        return new UserResource(auth()->guard('api')->user());
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' =>'required|email|unique:users,email',
                /* 'type' => 'alpha_num('u','o','a')', */
                'password' => 'min:3',
                'nif' => 'min:9' 
            ]);
            //\Log::info($request->all()); DEBUG!!

        $exploded = explode(',', $request->photo);
        $decoded = base64_decode($exploded[1]);
        
        if(str_contains($exploded[0], 'jpeg'))
            $extension = '.jpg';
        else
            $extension = '.png';

        $fileName = '_'.str_random().'.'.$extension;
        $path = public_path('/storage/fotos').'/'.$fileName;
        file_put_contents($path, $decoded);

        
        $user = new User();
        $user->fill($request->except('photo')); //request->all
        $user->password = Hash::make($user->password);
        $user->photo = $fileName;
        $user->save();
        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
                'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $user = User::findOrFail($id);

        //testar
        if($user->name != $request->name && $request->name != null){
            $user->name = $request->name;
        }
        if($user->type != $request->type && $request->type != null){
            $user->type = $request->type;
        }
        if($user->email != $request->email && $request->email != null){
            $user->email = $request->email;
        }

        if($request->photo != null && $user->photo != $request->photo){
            $exploded = explode(',', $request->photo);
            $decoded = base64_decode($exploded[1]);
            if(str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            else
                $extension = 'png';
        
            $fileName = '_'.str_random().'.'.$extension;
            $path = public_path('/storage/fotos').'/'.$fileName;
            file_put_contents($path, $decoded);
        }

        if($request->currentPassword != null && $request->password != null){
            if(!Hash::check($request->currentPassword, $user->password))
                return response()->json('Forbidden, wrong current password', 403);
        }

        if($request->password != null){
            $user->password = $request->password;
            $user->password = Hash::make($user->password);
        }
        if($request->photo != null && $user->photo != $request->photo){
            $user->photo = $fileName;
            $user->update($request->photo);
        }
        
        $user->update($request->except('currentPassword','password','photo','name','type','email'));

        $user->save();
        return new UserResource($user);
    }

    public function toggleActive(Request $request, $id)
    {
        $request->validate([
                'active' => 'required',
        ]);

        $user = User::findOrFail($id);
        
        $user->active = $request->active;

        $user->save();
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }
}
