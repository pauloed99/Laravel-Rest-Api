<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);

        return response()->json(['user' => $user], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json(['msg' => 'O usuário não existe !'], 400);
        }

        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $email)
    {   
        $data = $request->only(['firstname', 'lastname']);

        $user = User::where('email', $email)->update($data);

        if(!$user){
            return response()->json(['msg' => 'O usuário não existe !'], 400);
        }

        return response()->json(['msg' => 'Usuário atualizado com sucesso !'], 200);
    }

    public function updatePassword(UpdatePasswordUserRequest $request, $email)
    {
        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json(['msg' => 'O usuário não existe !'], 400);
        }

        if(User::compareHash($request->password, $user->password)){
            $request->password2 = Hash::make($request->password2);

            User::where('email', $email)->update(['password' => $request->password2]);

            return response()->json(['msg' => 'Senha Redefinida com sucesso !'], 200);
        }

        return response()->json(['msg' => 'Antiga senha incorreta !'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($email)
    {
        $user = User::where('email', $email)->delete();

        if(!$user){
            return response()->json(['msg' => 'O usuário não existe !'], 400);
        }

        return response()->json(['msg' => 'Usuário deletado com sucesso !'], 200);
    }
}
