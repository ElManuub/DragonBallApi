<?php

namespace App\Http\Controllers\auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = $request->validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);

            $user = new User;
            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = bcrypt(request()->password);
            $user->save();

            return response()->json([
                'message' => 'usuario creado con exito.',
                'user' => $user
            ],  status: 201);
        } catch (ValidationException $error) {

            return response()->json([
                'error' => $error->validator->errors(),
                'message' => 'hubo un problema con la validacion de algun dato.'
            ], 422);

        } catch (Exception $error) {

            return response()->json([
                'error' => $error->getMessage(),
                'message' => 'hubo un problema en el servidor.'
            ], 500);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Email o Pasword incorrectos'
                ], 401);
            }

            $user = Auth::user();

            return response()->json([
                'token' => $token,
                'usuario' => [
                    'email' => $user->email,
                    'id' => $user->id
                    ]
            ], 200);

        } catch (JWTException $e) {

            return response()->json([
                'message' => 'No se pudo crear el token.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
