<?php

namespace App\Http\Controllers\V1;
use App\Models\Pedido;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PedidosController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Muestra un listado del recurso
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //Listamos todos los pedidos
        return Pedido::get();
    }
    /**
     * Alamacena un nuevo recurso creado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validamos los datos
        $data = $request->only('PedUsu', 'PedPro', 'PedVrUnit', 'PedCant', 'PedSubtot', 'PedIVA', 'PedTotal');
        $validator = Validator::make($data, [
            'PedUsu'  => 'required|integer',
            'PedPro' => 'required|integer',
            'PedVrUnit' => 'required|numeric',
            'PedCant' => 'required|numeric',
            'PedSubtot' => 'required|numeric',
            'PedIVA' => 'required|numeric',
            'PedTotal' => 'required|numeric',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el pedido en la BD
        $pedido = Pedido::create([
            'PedUsu'  => $request->PedUsu,
            'PedPro' => $request->PedPro,
            'PedVrUnit' => $request->PedVrUnit,
            'PedCant' => $request->PedCant,
            'PedSubtot' => $request->PedSubtot,
            'PedIVA' => $request->PedIVA,
            'PedTotal' => $request->PedTotal,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Pedido creado',
            'data' => $pedido
        ], Response::HTTP_OK);
    }
    /**
     * Muestra un recurso especifico.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //Bucamos el pedido
        $pedido = Pedido::find($id);
        //Si el pedido no existe devolvemos error no encontrado
        if (!$pedido) {
            return response()->json([
                'message' => 'Pedido no se encontro.'
            ], 404);
        }
        //Si hay pedido lo devolvemos
        return $pedido;
    }
    /**
     * Actualiza un recurso creado especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('PedUsu', 'PedPro', 'PedVrUnit', 'PedCant', 'PedSubtot', 'PedIVA', 'PedTotal');
        $validator = Validator::make($data, [
            'PedUsu'  => 'required|integer',
            'PedPro' => 'required|integer',
            'PedVrUnit' => 'required|numeric',
            'PedCant' => 'required|numeric',
            'PedSubtot' => 'required|numeric',
            'PedIVA' => 'required|numeric',
            'PedTotal' => 'required|numeric',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el pedido
        $pedido = Pedido::findOrfail($id);
        //Actualizamos el pedido
        $pedido->update([
            'PedUsu'  => $request->PedUsu,
            'PedPro' => $request->PedPro,
            'PedVrUnit' => $request->PedVrUnit,
            'PedCant' => $request->PedCant,
            'PedSubtot' => $request->PedSubtot,
            'PedIVA' => $request->PedIVA,
            'PedTotal' => $request->PedTotal,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Pedido actualizado con exito',
            'data' => $pedido
        ], Response::HTTP_OK);
    }
    /**
     * Elimina un recurso especificado en la base de datos.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el pedido
        $pedido = Pedido::findOrfail($id);
        //Eliminamos el pedido
        $pedido->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Pedido eliminado con exito'
        ], Response::HTTP_OK);
    }
}
