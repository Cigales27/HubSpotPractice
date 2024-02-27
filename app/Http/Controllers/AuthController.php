<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUsuarioRequest;
use App\Http\Requests\RegistroUsuarioRequest;
use App\Mail\RegistroUsuario;
use App\Mail\VerificarUsuario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function registrar(RegistroUsuarioRequest $request)
    {
        DB::beginTransaction();
        try {
            $usuario = User::create([
                'name'     => $request->nombre,
                'email'    => $request->correo,
                'password' => bcrypt($request->contrasenia),
                'activo'   => 1,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Usuario registrado correctamente',
                'data'    => $usuario,
                'status'  => 'success',
                "code"    => "201"
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'status'  => 'error']);
        }
    }

    public function login(Request $request)
    {
        $credenciales = [
            'email'    => $request->correo,
            'password' => $request->contrasenia,
        ];
        if (!auth()->attempt($credenciales)) return response()->json(['message' => 'Credenciales incorrectas', 'status' => 'error', 'code' => 401], 401);

        if (!$user = User::where('email', $request->correo)->where('activo', 1)->first()) return response()->json(['message' => 'Usuario Inactivo', 'status' => 'error', 'code' => 401], 401);
        Session::put('usuario', $user);
        $user->tokens()->delete();
        $token = auth()->user()->createToken('auth_token', ['expires_in' => 3600], Carbon::now('America/Mexico_City')->addHour())->plainTextToken;
        Session::put('token', $token);
        Session::save();
        return response()->json([
            'access_token' => $token,
            'message'      => 'Usuario logueado correctamente',
            'status'       => 'success',
            'usuario'      => $user,
            'code'         => 200
        ], 200);
    }

    public function registrar_vista(Request $request)
    {
        return view('registrar');
    }

    public function iniciar_sesion(Request $request)
    {
        $credenciales = [
            'email'    => $request->correo,
            'password' => $request->contrasenia,
        ];
        if (!auth()->attempt($credenciales)) return view('login', ['errors' => 'Credenciales incorrectas']);

        if (!$user = User::where('email', $request->correo)->where('activo', 1)->first()) return view('login', ['errors' => 'Usuario Inactivo']);
        Session::put('usuario', $user);
        $user->tokens()->delete();
        $token = auth()->user()->createToken('auth_token', ['expires_in' => 3600], Carbon::now('America/Mexico_City')->addHour())->plainTextToken;
        Session::put('token', $token);
        Session::save();
        return redirect()->route('dashboard')->with(['nombre_view' => 'inicio', 'usuario' => $user]);
    }

    public function verificarUsuario(Request $request)
    {
        $user = User::where('email_verification_token', $request->token)->first();
        if (!$user) throw new HttpException(404, 'Usuario no encontrado');
        DB::beginTransaction();
        try {
            $verificarEmail = $user->update([
                'email_verified_at'        => Carbon::now(),
                'email_verification_token' => null,
                'activo'                   => 1,
            ]);
            if (!$verificarEmail) throw new HttpException(500, 'Error al verificar el correo');
            Mail::to($user->email)->send(new VerificarUsuario($user));
            DB::commit();
            return response()->json([
                'message' => 'Usuario verificado correctamente',
                'status'  => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'status'  => 'error']);
        }

    }

    public function logout(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->tokens()->delete();
        session()->flush();
        return redirect()->route('login');
    }

    public function dashboard(Request $request)
    {
        if (!auth()->user()) return redirect()->route('login');
        $id = auth()->user()->id;
        $usuario = User::where('id', $id)->first();
        Session::put('usuario', $usuario);
        return view('dashboard.home', ['usuario' => $usuario]);
    }
}

