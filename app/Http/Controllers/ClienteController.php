<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    //
    public function crearCliente(Request $request)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::create([
                'nombre_cliente'     => $request->nombre_cliente,
                'numero_cliente'     => $request->numero_cliente,
                'correo_electronico' => $request->correo_electronico,
                'direccion'          => $request->direccion,
                'ciudad'             => $request->ciudad,
                'estado'             => $request->estado,
                'codigo_postal'      => $request->codigo_postal,
                'id_empresa'         => $request->id_empresa,
                'activo'             => 1,
            ]);
            if (!$cliente) throw new \Exception("Ocurrio un error al crear el cliente", 500);
            DB::commit();
            return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente creado correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerClientes()
    {
        $clientes = Cliente::where('clientes.activo', 1)
            ->join('empresas', 'clientes.id_empresa', '=', 'empresas.id')
            ->where('empresas.activo', 1)
            ->where('empresas.id_usuario', auth()->user()->id)
            ->with('empresa')
            ->get();
        if (count($clientes) > 0) {
            foreach ($clientes as $cliente) {
                $cliente->direccion_completa = $cliente->direccion . ', ' . $cliente->ciudad . ', ' . $cliente->estado . ', ' . $cliente->codigo_postal;
                $cliente->creacion = Carbon::parse($cliente->created_at)->format('Y-m-d H:i:s');
                $cliente->actualizacion = Carbon::parse($cliente->updated_at)->format('Y-m-d H:i:s');
            }
        }
        return response()->json(['data' => $clientes, 'status' => "success", 'code' => 200, 'message' => "Clientes obtenidos correctamente"], 200);
    }

    public function obtenerClientePorId($id)
    {
        $cliente = Cliente::where('clientes.id', $id)->where('clientes.activo', 1)
            ->join('empresas', 'clientes.id_empresa', '=', 'empresas.id')
            ->where('empresas.activo', 1)
            ->first();
        if (!$cliente) return response()->json(['data' => null, 'status' => "error", 'code' => 404, 'message' => "Cliente no encontrado"], 404);
        return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente obtenido correctamente"], 200);
    }

    public function actualizarCliente(Request $request)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('id', $request->id)->first();
            if (!$cliente) throw new \Exception("Cliente no encontrado", 404);
            $cliente->update([
                'nombre_cliente'     => $request->nombre_cliente,
                'numero_cliente'     => $request->numero_cliente,
                'correo_electronico' => $request->correo_electronico,
                'direccion'          => $request->direccion,
                'ciudad'             => $request->ciudad,
                'estado'             => $request->estado,
                'codigo_postal'      => $request->codigo_postal,
                'id_empresa'         => $request->id_empresa,
            ]);
            if (!$cliente) throw new \Exception("Ocurrio un error al actualizar el cliente", 500);
            DB::commit();
            return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente actualizado correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => $e->getCode(), 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function eliminarCliente($id)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('id', $id)->first();
            if (!$cliente) throw new \Exception("Cliente no encontrado", 404);
            $cliente->update(['activo' => 0]);
            if (!$cliente) throw new \Exception("Ocurrio un error al eliminar el cliente", 500);
            DB::commit();
            return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente eliminado correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => $e->getCode(), 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function eliminarClientePermanente($id)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('id', $id)->first();
            if (!$cliente) throw new \Exception("Cliente no encontrado", 404);
            $cliente->delete();
            if (!$cliente) throw new \Exception("Ocurrio un error al eliminar el cliente", 500);
            DB::commit();
            return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente eliminado correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => $e->getCode(), 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function reactivarCliente($id)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::where('id', $id)->first();
            if (!$cliente) throw new \Exception("Cliente no encontrado", 404);
            $cliente->update(['activo' => 1]);
            if (!$cliente) throw new \Exception("Ocurrio un error al reactivar el cliente", 500);
            DB::commit();
            return response()->json(['data' => $cliente, 'status' => "success", 'code' => 200, 'message' => "Cliente reactivado correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => $e->getCode(), 'message' => $e->getMessage()], $e->getCode());
        }
    }

    public function clientes()
    {
        if (!auth()->user()) return redirect()->route('login');
        $id = auth()->user()->id;
        $usuario = User::where('id', $id)->first();
        Session::put('usuario', $usuario);
        return view('dashboard.cliente.cliente');
    }

}
