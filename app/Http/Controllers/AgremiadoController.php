<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agremiado;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AgremiadoController extends Controller
{

    //Función para crear un nuevo agremiado
    public function newAgremiado(Request $request){

        $validator = Validator::make($request->all(), [
            'a_paterno' => 'required|string|max:50',
            'a_materno' => 'required|string|max:50',
            'nombre' => 'required|string|max:50',
            'sexo' => 'required|string|max:50',
            'NUP' => 'required',
            'NUE' => 'required',
            'RFC' => 'required|string|min:13|max:13',
            'NSS' => 'required|string|min:11|max:11',
            'f_nacimiento' => 'required',
            'telefono' => 'required',
            'cuota' => 'required',

        ]);

        if (Agremiado::where('NUE', $request->NUE)->exists()) {
            return response()->json(['error' => 'El NUE ya existe en la base de datos'], 422);
        }

        if (!$request->has('expire')) {
            $request->merge(['expire' => null]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
            

        //$rutaArchivoImg = $request->file('image')->store('public/imgproductos');
        $agremiado = Agremiado::create([
            'a_paterno' => $request->a_paterno,
            'a_materno' => $request->a_materno,
            'nombre' => $request->nombre,
            'sexo' => $request->sexo,
            'NUP' => $request->NUP,
            'NUE' => $request->NUE,
            'RFC' => $request->RFC,
            'NSS' => $request->NSS,
            'f_nacimiento' => $request->f_nacimiento,
            'telefono' => $request->telefono,
            'cuota' => $request->cuota,
        ]);

        // Crear el usuario asociado
            User::create([
                'NUE' => $request->NUE,
                'password' => bcrypt($request->NUE), // Asegúrate de encriptar la contraseña
                'id_rol' => 2
                // Agrega otros campos necesarios para el usuario
            ]);

        return response()->json(['Agremiado' => $agremiado], 201);
    }

    //Función para obtener todos los agremiados registraddos en la BD
    public function getAgremiados(){
        return response()->json(Agremiado::all(), 200);
    }

    //Funcion para obtener la informacion de un agremiado por medio de su ID
    public function getAgremiadoById($id){
        $agremiado = Agremiado::find($id);
        if(is_null($agremiado)){
            return response()->json(['msn'=> 'Agremiado no encontrado '], 404);
        }
        return response()->json($agremiado, 200);
    }
}
