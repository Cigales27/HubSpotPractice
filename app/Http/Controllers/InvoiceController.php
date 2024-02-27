<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Invoice;
use App\Models\InvoiceDetalle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{


    public function crearFactura(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!isset($request->id_usuario) || $request->id_usuario == null || $request->id_usuario == "") {
                $request->id_usuario = Auth::user()->id;
            }
            if (!isset($request->id_empresa) || $request->id_empresa == null || $request->id_empresa == "") {
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
                    'activo'             => 1,
                    'id_usuario'         => $request->id_usuario ?? Auth::user()->id
                ]);
                if (!$empresa) throw new \Exception("Error al crear la empresa", 500);
                $logo = $request->file('logo');
                $nombre_logo = $logo->getClientOriginalName();
                $nombre_logo = preg_replace('([^A-Za-z0-9.])', '', $nombre_logo);
                $nombre_logo = Carbon::now()->timestamp . '_' . $nombre_logo;
                $path = 'app/public/empresas/' . $empresa->id . '/';
                $ruta = storage_path($path);
                $logo->move($ruta, $nombre_logo);
                $empresa->url_logo = $path . $nombre_logo;
                $empresa->save();
                $request->id_empresa = $empresa->id;
            }
            if (!isset($request->id_cliente) || $request->id_cliente == null || $request->id_cliente == "") {
                $cliente = Cliente::create([
                    'id_empresa'         => $request->id_empresa,
                    'nombre_cliente'     => $request->nombre_cliente,
                    'numero_cliente'     => $request->numero_cliente,
                    'correo_electronico' => $request->correo_electronico_cliente,
                    'direccion'          => $request->direccion_cliente,
                    'ciudad'             => $request->ciudad_cliente,
                    'estado'             => $request->estado_cliente,
                    'codigo_postal'      => $request->codigo_postal_cliente,
                    'activo'             => 1
                ]);
                if (!$cliente) throw new \Exception("Error al crear el cliente", 500);
                $request->id_cliente = $cliente->id;
            }
            $nombre_invoice = Carbon::now()->format('Y-m-d') . '_' . $request->id_empresa . '_' . $request->id_cliente;
            $invoice = Invoice::create([
                'id_empresa'                => $request->id_empresa,
                'id_usuario'                => $request->id_usuario,
                'id_cliente'                => $request->id_cliente,
                'nombre_invoice'            => $nombre_invoice,
                'numero_invoice'            => $request->numero_invoice,
                'fecha_invoice'             => $request->fecha_invoice,
                'fecha_vencimiento_invoice' => $request->fecha_vencimiento_invoice,
                'comentario_invoice'        => $request->comentario_invoice,
                'subtotal_invoice'          => $request->subtotal_invoice,
                'impuesto_invoice'          => $request->impuesto_invoice,
                'total_invoice'             => $request->total_invoice,
                'activo'                    => 1
            ]);
            if (!$invoice) throw new \Exception("Ocurrio un error al crear la factura", 500);
            $detalles = json_decode($request->detalle, true);
            foreach ($detalles as $detalle) {
                $invoideDetalle = InvoiceDetalle::create([
                    'id_invoice'      => $invoice->id,
                    'nombre_producto' => $detalle['nombre_producto'],
                    'cantidad'        => $detalle['cantidad'],
                    'precio'          => $detalle['precio'],
                    'activo'          => 1
                ]);
                if (!$invoideDetalle) throw new \Exception("Ocurrio un error al crear el detalle de la factura", 500);
            }
            DB::commit();
            return response()->json(['data' => $invoice, 'status' => "success", 'code' => 201, 'message' => "Factura creada correctamente"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerFacturas(Request $request)
    {
        try {
            $facturas = Invoice::where('id_usuario', auth()->user()->id)
                ->with('invoiceDetalle', 'cliente', 'empresa')
                ->where('activo', 1)->get();
            if (count($facturas) > 0) {
                foreach ($facturas as $factura) {
                    $factura->creacion = Carbon::parse($factura->created_at)->format('Y-m-d H:i:s');
                    $factura->actualizacion = Carbon::parse($factura->updated_at)->format('Y-m-d H:i:s');
                }
            }
            return response()->json(['data' => $facturas, 'status' => "success", 'code' => 200, 'message' => "Facturas obtenidas correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function obtenerFacturaPorId($id)
    {
        try {
            $factura = Invoice::where('id', $id)
                ->with('invoiceDetalle', 'cliente', 'empresa')
                ->where('activo', 1)->first();
            if (!$factura) throw new \Exception("La factura no existe", 404);
            return response()->json(['data' => $factura, 'status' => "success", 'code' => 200, 'message' => "Factura obtenida correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function actualizarFactura(Request $request)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::find($request->id);
            if (!$invoice) throw new \Exception("La factura no existe", 404);
            if (!isset($request->id_usuario) || $request->id_usuario == null || $request->id_usuario == "") {
                $request->id_usuario = Auth::user()->id;
            }
            $invoice->update([
                'id_empresa'                => $request->id_empresa,
                'id_usuario'                => $request->id_usuario,
                'id_cliente'                => $request->id_cliente,
                'numero_invoice'            => $request->numero_invoice,
                'fecha_invoice'             => $request->fecha_invoice,
                'fecha_vencimiento_invoice' => $request->fecha_vencimiento_invoice,
                'comentario_invoice'        => $request->comentario_invoice,
                'subtotal_invoice'          => $request->subtotal_invoice,
                'impuesto_invoice'          => $request->impuesto_invoice,
                'total_invoice'             => $request->total_invoice,
                'activo'                    => 1
            ]);
            if (!$invoice) throw new \Exception("Ocurrio un error al actualizar la factura", 500);
            $detalles = json_decode($request->detalle, true);
            foreach ($detalles as $detalle) {
                if (isset($detalle['id'])) {
                    $invoideDetalle = InvoiceDetalle::find($detalle['id']);
                    if (!$invoideDetalle) throw new \Exception("El detalle de la factura no existe", 404);
                    $invoideDetalle->update([
                        'id_invoice'      => $invoice->id,
                        'nombre_producto' => $detalle['nombre_producto'],
                        'cantidad'        => $detalle['cantidad'],
                        'precio'          => $detalle['precio'],
                        'activo'          => 1
                    ]);
                    if (!$invoideDetalle) throw new \Exception("Ocurrio un error al actualizar el detalle de la factura", 500);
                } else {
                    $invoideDetalle = InvoiceDetalle::create([
                        'id_invoice'      => $invoice->id,
                        'nombre_producto' => $detalle['nombre_producto'],
                        'cantidad'        => $detalle['cantidad'],
                        'precio'          => $detalle['precio'],
                        'activo'          => 1
                    ]);
                    if (!$invoideDetalle) throw new \Exception("Ocurrio un error al crear el detalle de la factura", 500);
                }
            }
            DB::commit();
            return response()->json(['data' => $invoice, 'status' => "success", 'code' => 200, 'message' => "Factura actualizada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function eliminarFactura($id)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) throw new \Exception("La factura no existe", 404);
            $invoice->update([
                'activo' => 0
            ]);
            if (!$invoice) throw new \Exception("Ocurrio un error al eliminar la factura", 500);
            DB::commit();
            return response()->json(['data' => $invoice, 'status' => "success", 'code' => 200, 'message' => "Factura eliminada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function eliminarFacturaPermanente($id)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) throw new \Exception("La factura no existe", 404);
            $invoice->delete();
            if (!$invoice) throw new \Exception("Ocurrio un error al eliminar la factura", 500);
            DB::commit();
            return response()->json(['data' => $invoice, 'status' => "success", 'code' => 200, 'message' => "Factura eliminada permanentemente correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function reactivarFactura($id)
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::find($id);
            if (!$invoice) throw new \Exception("La factura no existe", 404);
            $invoice->update([
                'activo' => 1
            ]);
            if (!$invoice) throw new \Exception("Ocurrio un error al reactivar la factura", 500);
            DB::commit();
            return response()->json(['data' => $invoice, 'status' => "success", 'code' => 200, 'message' => "Factura reactivada correctamente"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data' => null, 'status' => "error", 'code' => 500, 'message' => $e->getMessage()], 500);
        }
    }

    public function facturas()
    {
        if (!auth()->user()) return redirect()->route('login');
        $id = auth()->user()->id;
        $usuario = User::where('id', $id)->first();
        Session::put('usuario', $usuario);
        return view('facturas.factura');
    }

    public function crear_factura()
    {
        if (!auth()->user()) return redirect()->route('login');
        $id = auth()->user()->id;
        $usuario = User::where('id', $id)->first();
        Session::put('usuario', $usuario);
        return view('facturas.create_factura');
    }

    public function editar_factura($id)
    {
        if (!auth()->user()) return redirect()->route('login');
        $idUsuario = auth()->user()->id;
        $usuario = User::where('id', $idUsuario)->first();
        Session::put('usuario', $usuario);
        $factura = Invoice::where('id', $id)->with('invoiceDetalle', 'cliente', 'empresa')
            ->where('activo', 1)->first();
        \Log::info($factura);
        return view('facturas.create_factura', ['factura' => $factura]);
    }
}
