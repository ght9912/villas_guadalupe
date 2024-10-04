<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendedores;
use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function search(Request $request)
    {

        $busqueda = $request->busqueda;

        $clientesEmails = clientes::pluck('email');

        if($request->busqueda==null){
        }else{

            $users = User::where(function ($query) use ($busqueda) {
                $query->where('name', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('email', 'LIKE', '%' . $busqueda . '%');
            })
                    ->whereNotIn('email', $clientesEmails)
                    ->get();

            return $users;
        }
    }

    public function search2(Request $request)
    {

        $busqueda = $request->busqueda;

        $vendedoresEmails = Vendedores::pluck('email');

        if($request->busqueda==null){
        }else{

            $users = User::where(function ($query) use ($busqueda) {
                $query->where('name', 'LIKE', '%' . $busqueda . '%')
                    ->orWhere('email', 'LIKE', '%' . $busqueda . '%');
            })
                    ->whereNotIn('email', $vendedoresEmails)
                    ->get();

            return $users;
        }
    }

}
