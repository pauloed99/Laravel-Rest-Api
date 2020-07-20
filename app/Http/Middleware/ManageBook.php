<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class ManageBook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Gate::allows('manageProduct')){
            return $next($request);
        }

        return response()->json(['msg' => 'Você não possui autorização para acessar esta rota !'], 400);
        
    }
}
