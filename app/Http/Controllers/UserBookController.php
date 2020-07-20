<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookController extends Controller
{   
    public function __construct()
    {
        $this->middleware('apiJwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->is_admin === true){
            $users = User::with('books')->paginate(4);

            return response()->json(['users' => $users], 200);
        }

        $user = User::where('email', Auth::user()->email)->with('books')->first();  
        
        return response()->json(['user' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('email', Auth::user()->email)->first();

        $book = Book::where('id', $request->id)->first();

        if(!$book){
            return response()->json(['msg' => 'O produto não existe !'], 400);
        }
    
        $user->books()->attach($request->id);

        return response()->json(['msg' => 'Produto Adicionado ao carrinho !'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('email', Auth::user()->email)->first();

        $userBook = $user->books()->wherePivot('id', $id)->first();

        if(!$userBook){
            return response()->json(['msg' => 'Você não possui acesso a este recurso !']);
        }

        return response()->json(['userBook' => $userBook], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('email', Auth::user()->email)->first();

        $status = $user->books()->wherePivot('id', $id)->detach();

        if(!$status){
            return response()->json(['msg' => 'Não foi possível deletar o produto !']);
        }

        return response()->json(['msg' => 'Produto deletado com sucesso !']);
    }
}
