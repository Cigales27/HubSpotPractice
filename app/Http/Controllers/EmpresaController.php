<?php

namespace App\Http\Controllers;

use App\Http\Requests\Empresa\ActualizarEmpresaRequest;
use App\Http\Requests\Empresa\CrearEmpresaRequest;
use App\Http\Requests\Empresa\ReactivarEmpresaRequest;
use App\Models\Empresa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{

    public function crearEmpresa(CrearEmpresaRequest $request)
    {
        DB::beginTransaction();
        try {
            $empresa = Empresa::create([
                'nombre_empresa'     => $request->nombre_empresa,
                'url_sitio_web'      => $request->url_sitio_web,
                'numero_empresa'     => $request->numero_empresa,
                'correo_electronico' => $request->correo_electronico,
                'url_logo'           => '',
                'direccion'          => $request->direccion,
                'ciudad'             => $request->ciudad,
                'estado'             => $request->estado,
                'codigo_postal'      => $request->codigo_postal,
                'id_usuario'         => $request->id_usuario,
            ]);
            if (!$empresa) throw new \Exception('No se pudo crear la empresa');
            $logo = $request->file('logo');
            $nombre_logo = $logo->getClientOriginalName();
            $nombre_logo = preg_replace('([^A-Za-z0-9.])', '', $nombre_logo);
            $nombre_logo = Carbon::now()->timestamp . '_' . $nombre_logo;
            $path = 'app/public/empresas/' . $empresa->id . '/';
            $ruta = storage_path($path);
            $logo->move($ruta, $nombre_logo);
            $empresa->url_logo = $path . $nombre_logo;
            $empresa->save();
            DB::commit();
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa creada correctamente", 'code' => 200], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }

    }

    public function obtenerEmpresas()
    {
        try {
            $empresas = Empresa::where('id_usuario', auth()->user()->id)
                ->where('activo', 1)
                ->with('clientes')->get();
            if (count($empresas) > 0) {
                foreach ($empresas as $empresa) {
                    if ($empresa->url_logo) {
                        $empresa->url_logo = base64_encode(file_get_contents(storage_path($empresa->url_logo)));
                    }
                    $empresa->direccion_completa = $empresa->direccion . ', ' . $empresa->ciudad . ', ' . $empresa->estado . ', ' . $empresa->codigo_postal;
                    $empresa->creacion = Carbon::parse($empresa->created_at)->format('Y-m-d H:i:s');
                    $empresa->actualizacion = Carbon::parse($empresa->updated_at)->format('Y-m-d H:i:s');
                }
            }
            return response()->json(['data' => $empresas, 'status' => "success", 'code' => 200, 'message' => "Empresas obtenidas correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerEmpresaPorId($id)
    {
        try {
            $empresa = Empresa::where('id', $id)->where('activo', 1)
                ->with('clientes')->first();
            if (!$empresa) throw new \Exception('No se encontró la empresa');
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa obtenida correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function actualizarEmpresa(ActualizarEmpresaRequest $request)
    {
        DB::beginTransaction();
        try {
            $empresa = Empresa::find($request->id);
            if (!$empresa) throw new \Exception('No se encontró la empresa');
            $empresa->update([
                'nombre_empresa'     => $request->nombre_empresa,
                'url_sitio_web'      => $request->url_sitio_web,
                'numero_empresa'     => $request->numero_empresa,
                'correo_electronico' => $request->correo_electronico,
                'direccion'          => $request->direccion,
                'ciudad'             => $request->ciudad,
                'estado'             => $request->estado,
                'codigo_postal'      => $request->codigo_postal,
            ]);
            if (!$empresa) throw new \Exception('No se pudo actualizar la empresa', 500);
            if (isset($request->logo) && $request->hasFile('logo')) {
                $logo = $request->file('logo');
                $nombre_logo = $logo->getClientOriginalName();
                $nombre_logo = preg_replace('([^A-Za-z0-9.])', '', $nombre_logo);
                $nombre_logo = Carbon::now()->timestamp . '_' . $nombre_logo;
                $path = 'app/public/empresas/' . $empresa->id . '/';
                unlink(storage_path($empresa->url_logo));
                $ruta = storage_path($path);
                $logo->move($ruta, $nombre_logo);
                $empresa->url_logo = $path . $nombre_logo;
                $empresa->save();
            }
            DB::commit();
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa actualizada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function eliminarEmpresa($id)
    {
        DB::beginTransaction();
        try {
            $empresa = Empresa::find($id);
            if (!$empresa) throw new \Exception('No se encontró la empresa');
            $empresa->update(['activo' => 0]);
            if (!$empresa) throw new \Exception('No se pudo eliminar la empresa');
            DB::commit();
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa eliminada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function eliminarEmpresaPermanente($id)
    {
        DB::beginTransaction();
        try {
            $empresa = Empresa::find($id);
            if (!$empresa) throw new \Exception('No se encontró la empresa');
            $empresa->delete();
            if (!$empresa) throw new \Exception('No se pudo eliminar la empresa');
            DB::commit();
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa eliminada permanentemente correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function reactivarEmpresa($id)
    {

        DB::beginTransaction();
        try {
            $empresa = Empresa::find($id);
            if (!$empresa) throw new \Exception('No se encontró la empresa');
            $empresa->update(['activo' => 1]);
            if (!$empresa) throw new \Exception('No se pudo reactivar la empresa');
            DB::commit();
            return response()->json(['data' => $empresa, 'status' => "success", 'code' => 200, 'message' => "Empresa reactivada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function empresas()
    {
        if (!auth()->user()) return redirect()->route('login');
        $id = auth()->user()->id;
        $usuario = User::where('id', $id)->first();
        Session::put('usuario', $usuario);
        return view('dashboard.empresa.empresa');
    }

}
