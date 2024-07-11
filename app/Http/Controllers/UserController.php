<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $response = Http::acceptJson()->get('https://test.drogueriahofmann.cl/usuarios/ListTableUsers');

        return Inertia::render('Users', ['users' => $response->json()]);
    }

    public function getUsersCode()
    {
        $response = Http::acceptJson()->get('https://test.drogueriahofmann.cl/usuarios/GetUsers');

        return $response->successful()
        ? $response->json()
        : response()->json(['error' => 'No se pudo obtener los códigos de usuarios'], $response->status());
    }

    public function sendUserData(Request $request)
    {
        try{
            $userData = $request->validate([
                'id' => 'required|integer',
                'code' => 'required|string',
                'amount' => 'required|numeric',
                'date' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
                'github' => 'required|string'
            ]);

            $response = Http::post('https://test.drogueriahofmann.cl/usuarios/SendUser', $userData);

            return $response->json();

        }catch (\Exception $e){
            return response()->json(['error' => 'Error al enviar los datos a la API externa'], 500);
        }

    }
}
