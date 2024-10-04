<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendedoresMail;
use App\Mail\WelcomeVendedorMail as MailW;

class VendedoresController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $usuarios= User::all();
        $vendedores = Vendedores::all()->map(function($e){
            $e->usuario;
            return $e;
        });


        $data=["vendedores"=>$vendedores,"recursos"=>["usuarios"=>$usuarios]];
        return view("vendedores",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        //
    }
    public function store(Request $r)
    {
        $r->validate([

            'email' => 'required|email|unique:users,email',
            'celular' => 'required',

         //validar que el email no se haya registrado antes

        ]);

        $contrasenaAlt = $this->contrasenaAlt();

        $user=User::create([
            'name' =>  $r->nombre,
            'email' => $r->email,
            'password' => Hash::make($contrasenaAlt),
        ]);

        Mail::to($user->email)->send(new VendedoresMail($r->nombre, $contrasenaAlt));

        $v=new Vendedores();
        $v->id=$r->id;
        $v->user_id = $user->id;
        $v->nombre =$r->nombre;
        $v->email=$r->email;
        $v->celular=$r->celular;
        $v->clientes=$r->clientes;
        $v->comisiones=$r->comisiones;
        $v->proyectos_participa=$r->proyectos_participa;
        $imagen = $r->file('imagen')->store('imagenesVendedor/'. $r->id,'public');
        $v->imagen =$imagen;
        $v->puesto=$r->puesto;
        $v->about=$r->about;
        $v->linkedin=$r->linkedin;
        $v->x=$r->x;
        $v->instagram=$r->insta;
        $v->facebook=$r->facebook;
        $v->email_alt=$r->emailAlt;
        $v->save();
        $v->usuario;

        return response()->json([
            'message' => 'Vendedor y Usuario Creado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }
/**
     * Genera una contrasena aleatoria.
     *
     * @param  Integer  $longitud
     * @return String
     */
    public function contrasenaAlt($longitud = 10) {

        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+{}[]|';
        $contrasena = '';

        // Añadir al menos una letra mayúscula
        $contrasena .= $caracteres[rand(26, 51)];

        // Añadir al menos una letra minúscula
        $contrasena .= $caracteres[rand(0, 25)];

        // Añadir al menos un carácter especial
        $contrasena .= $caracteres[rand(52, strlen($caracteres) - 1)];

        // Completar la longitud de la contraseña
        while (strlen($contrasena) < $longitud) {
            $contrasena .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Mezclar los caracteres para mayor aleatoriedad
        $contrasena = str_shuffle($contrasena);

        return $contrasena;



    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clientes  $clientes
     * @return \Illuminate\Http\Response
     */

    public function show(Vendedores $vendedores,$id)
    {
        return $vendedores::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $r->validate([
            'email' => 'required',
            'celular' => 'required',

        ]);

        $v = Vendedores::find($id);
        $v->nombre=$r->nombre;
        $v->email=$r->email;
        $v->celular=$r->celular;
        $v->clientes=$r->clientes;
        $v->comisiones=$r->comisiones;
        $v->proyectos_participa=$r->proyectos_participa;
        $v->puesto=$r->puesto;
        $v->about=$r->about;
        $v->linkedin=$r->linkedin;
        $v->x=$r->x;
        $v->instagram=$r->insta;
        $v->facebook=$r->facebook;
        $v->email_alt=$r->emailAlt;


        if ($r->hasFile('imagen')) {
            $image = $r->file('imagen')->store('imagenesVendedor/' . $r->id,'public');
            $v->imagen =$image;

        } elseif ($r->has('imagen_original')) {
            $v->imagen = $r->input('imagen_original');
        }

        $v->update();
        $v->usuario;


        return response()->json([
            'message' => 'Informacion de Vendedore Actualizado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $v = Vendedores::find($id);
        $v->delete();
        return response()->json([
            'message' => 'Vendedores eliminado con exito',
            'data' => [],
            'status' => 200,
        ],200);

    }

    public function saveFromUser(Request $r)
    {

        $r->validate([
            'id' => 'required',
        ]);

        $user = User::find($r->id);
        $c = new vendedores();
        $c->user_id= $user->id;
        $c->nombre= $user->name;
        $c->email = $user->email;
        $c->save();

        Mail::to($user->email)->send(new MailW($r->nombre));

        return response()->json([
            'message' => 'Vendedor agregado',
            'data' => $c,
            'status' => 200,
        ],200);
    }

    public function search(Request $request)
    {

        $busqueda = $request->busqueda;

        $vendedores = Vendedores::where('nombre', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('email','LIKE','%' . $busqueda . '%')
            ->get();

        return $vendedores;
    }

    public function detallesCliente( $id)
    {
        $vendedor = Vendedores::find($id);

        if (!$vendedor) {
            return redirect()->back()->with('error', 'Vendedor no encontrado');
        }

        return view('vendedoresDetalles', compact('vendedor'));
    }

    public function detallesRedes(Request $r, $id)
    {
        $v = Vendedores::find($id);
        $v->linkedin=$r->linkedin;
        $v->x=$r->x;
        $v->instagram=$r->insta;
        $v->facebook=$r->facebook;
        $v->email_alt=$r->emailAlt;
        $v->update();

        return response()->json([
            'message' => 'Informacion de detalles Actualizado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }

    public function detallesAbout(Request $r, $id)
    {
        $v = Vendedores::find($id);
        $v->about=$r->about;
        $v->update();

        return response()->json([
            'message' => 'Informacion acerca de Actualizado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }

    public function detallesImagen(Request $r, $id)
    {
        $v = Vendedores::find($id);
        $image = $r->file('imagen')->store('imagenesVendedor/' . $r->id,'public');
        $v->imagen =$image;
        $v->update();

        return response()->json([
            'message' => 'Imagen Actualizado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }

    public function detallesNombre(Request $r, $id)
    {
        $v = Vendedores::find($id);
        $v->nombre=$r->nombre;
        $v->update();

        return response()->json([
            'message' => 'Nombre Actualizado con exito',
            'data' => $v,
            'status' => 200,
        ],200);
    }


    public function infoVendedores ()
    {
        $vendedores = Vendedores::all();
        return response()->json($vendedores);
    }
}
