<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SolicituController extends Controller
{

    //Función para crear las Solicitudes segun el NUE del agreamiado
    public function newSolicitud(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NUE' => 'required|string|max:100',
            'ruta_archivo' => 'required|file|max:2048|mimetypes:image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        if (!$request->has('expire')) {
            $request->merge(['expire' => null]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $uploadedFile = $request->file('ruta_archivo'); // Corrección aquí
        $extension = $uploadedFile->getClientOriginalExtension();

        $allowedExtensions = ['pdf', 'docx', 'jpeg', 'jpg', 'png'];

        if (!in_array($extension, $allowedExtensions)) {
            return response()->json(['error' => 'Solo se permiten imágenes (jpeg, png), archivos PDF y Word (docx)'], 422);
        }

        $rutaArchivo = $uploadedFile->store('public/files');

        $solicitud = Solicitu::create([
            'NUE' => $request->NUE,
            'ruta_archivo' => $rutaArchivo, // Corrección aquí
        ]);

        return response()->json(['Solicitud' => $solicitud], 201);
    }

    //Funcion para obtener todoas las solicitudes
    public function getSolicitudes(){

        $solicitudes=Solicitu::all();
        foreach ($solicitudes as $solicitud) {
            $solicitud->ruta_archivo = asset(Storage::url($solicitud->ruta_archivo));
        }
        return response()->json($solicitudes, 200);
    }
    
    //Función para obtener las solitudes de un usuario por su NUE
    public function getSolicitudByNUE($NUE){
        
        $solicitudes = Solicitu::where('NUE', $NUE)->get();
    
        if (is_null($solicitudes)) {
            return response()->json(['msn'=> 'No hay solicitudes para el NUE proporcionado'], 404);
        }

        foreach ($solicitudes as $solicitud) {
            $solicitud->ruta_archivo = asset(Storage::url($solicitud->ruta_archivo));
        }
        return response()->json($solicitudes, 200);
    }


    //Función para obtener y descargar el archivo
    public function getArchivo($ruta_archivo)
{
    $filePath = public_path('storage/files/' . $ruta_archivo);

    if (file_exists($filePath)) {
        $headers = [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ];

        return response()->download($filePath, null, $headers);
    } else {
        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }
}

    
    
    
}
