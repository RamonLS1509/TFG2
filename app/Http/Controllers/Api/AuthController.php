<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación y gestión de usuarios"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     description="Permite crear un nuevo usuario en la aplicación",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuario registrado correctamente"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
   public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Determinar si este es el primer usuario
    $role = User::count() === 0 ? 'admin' : 'user';

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $role,
    ]);

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user,
        'token' => $token,
    ], 201);
}

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión",
     *     description="Genera un token de autenticación JWT para el usuario",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Inicio de sesión exitoso", @OA\JsonContent(
     *         @OA\Property(property="access_token", type="string"),
     *         @OA\Property(property="token_type", type="string", example="bearer"),
     *         @OA\Property(property="expires_in", type="integer", example=3600)
     *     )),
     *     @OA\Response(response=401, description="Credenciales inválidas")
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Obtener perfil del usuario autenticado",
     *     description="Devuelve la información del usuario autenticado",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Perfil del usuario", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión",
     *     description="Revoca el token del usuario actual",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Cierre de sesión exitoso"),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Refrescar el token JWT (opcional)",
     *     description="Devuelve un nuevo token de acceso si usas JWT (no necesario con Sanctum)",
     *     tags={"Auth"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Token actualizado"),
     *     @OA\Response(response=401, description="No autenticado")
     * )
     */
    public function refresh()
    {
        return response()->json(['message' => 'Refrescar token no implementado (opcional para JWT)']);
    }
}
