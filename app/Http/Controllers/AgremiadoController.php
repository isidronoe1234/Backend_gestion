<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agremiado;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgremiadoController extends Controller
{

    //Función para crear un nuevo agremiado
    public function newAgremiado(Request $request)
    {

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

        if (Agremiado::where('RFC', $request->RFC)->exists()) {
            return response()->json(['error' => 'El RFC ya existe en la base de datos'], 422);
        }

        if (Agremiado::where('NSS', $request->NSS)->exists()) {
            return response()->json(['error' => 'El NSS ya existe en la base de datos'], 422);
        }

        if (Agremiado::where('telefono', $request->telefono)->exists()) {
            return response()->json(['error' => 'El número de teléfono ya existe en la base de datos'], 422);
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
    public function getAgremiados()
    {
        $informacion = DB::table('users')
            ->join('agremiados', 'users.NUE', '=', 'agremiados.NUE')
            ->where('users.id_rol', 2)
            ->where('agremiados.status', 1)
            ->select('users.*', 'agremiados.*')
            ->get();

        return response()->json($informacion, 200);
    }

    //Funcion para obtener la informacion de un agremiado por medio de su ID
    public function getAgremiadoById($id)
    {
        $agremiado = Agremiado::find($id);
        if (is_null($agremiado)) {
            return response()->json(['msn' => 'Agremiado no encontrado '], 404);
        }
        return response()->json($agremiado, 200);
    }

    //Funcion para desactivar getAgremiados
    public function deactivateAgremiadoById($id)
    {
        $agremiado = Agremiado::find($id);

        if (!$agremiado) {
            return response()->json(['message' => 'Agremiado no encontrado'], 404);
        }

        $agremiado->update(['status' => 0]);

        return response()->json(['message' => 'Agremiado desactivado con éxito', 'Agremiado' => $agremiado]);
    }

    public function updateAgremiadoById(Request $request, $id)
    {
        $agremiado = Agremiado::find($id);

        if (!$agremiado) {
            return response()->json(['message' => 'Agremiado no encontrado'], 404);
        }

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

        if (Agremiado::where('NUE', $request->NUE)->where('id', '!=', $id)->exists()) {
            return response()->json(['error' => 'El NUE ya existe en la base de datos'], 422);
        }

        if (Agremiado::where('RFC', $request->RFC)->where('id', '!=', $id)->exists()) {
            return response()->json(['error' => 'El RFC ya existe en la base de datos'], 422);
        }

        if (Agremiado::where('NSS', $request->NSS)->where('id', '!=', $id)->exists()) {
            return response()->json(['error' => 'El NSS ya existe en la base de datos'], 422);
        }

        if (Agremiado::where('telefono', $request->telefono)->where('id', '!=', $id)->exists()) {
            return response()->json(['error' => 'El número de teléfono ya existe en la base de datos'], 422);
        }
        

        if (!$request->has('expire')) {
            $request->merge(['expire' => null]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }       

        $data = $request->all();

        $agremiado->update($data);

        return response()->json(['message' => 'Agremiado actualizado con éxito', 'Agremiado' => $agremiado]);
    }


    public function getAgremiadosArchivados()
    {
        $informacion = DB::table('users')
            ->join('agremiados', 'users.NUE', '=', 'agremiados.NUE')
            ->where('users.id_rol', 2)
            ->where('agremiados.status', 0)
            ->select('users.*', 'agremiados.*')
            ->get();

        return response()->json($informacion, 200);
    }

    public function activateAgremiadoById($id)
    {
        $agremiado = Agremiado::find($id);

        if (!$agremiado) {
            return response()->json(['message' => 'Agremiado no encontrado'], 404);
        }

        $agremiado->update(['status' => 1]);

        return response()->json(['message' => 'Agremiado activado con éxito', 'Agremiado' => $agremiado]);
    }
}
