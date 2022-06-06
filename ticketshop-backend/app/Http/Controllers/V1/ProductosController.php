<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ProductosController extends Controller
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
     * Muestra un listado del recurso.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //Listamos todos los productos
        return Producto::get();
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
        $data = $request->only('ProDesc', 'ProValor');
        $validator = Validator::make($data, [
            'ProDesc' => 'required|max:150|string',
            'ProValor' => 'required|numeric',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el producto en la BD
        $producto = Producto::create([
            'ProDesc' => $request->ProDesc,
            'ProValor' => $request->ProValor,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Producto creado',
            'data' => $producto
        ], Response::HTTP_OK);
    }
    /**
     * Muestra un recurso especifico.
     *
     * @param  \App\Models\Product  $producto
     * @return \Illuminate\Http\Response
     */

    public function show($ProID)
    {
        //Bucamos el producto
        $producto = Producto::find($ProID);
        //Si el producto no existe devolvemos error no encontrado
        if (!$producto) {
            return response()->json([
                'message' => 'Product no se encontro.'
            ], 404);
        }
        //Si hay producto lo devolvemos
        return $producto;
    }
    /**
     * Actualiza un recurso creado especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validación de datos
        $data = $request->only('ProDesc', 'ProValor');
        $validator = Validator::make($data, [
            'ProDesc' => 'required|max:150|string',
            'ProValor' => 'required|numeric',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el producto
        $producto = Producto::findOrfail($id);
        //Actualizamos el producto.
        $producto->update([
            'ProDesc' => $request->ProDesc,
            'ProValor' => $request->ProValor,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Product actualizado con exito',
            'data' => $producto
        ], Response::HTTP_OK);
    }
    /**
     * Elimina un recurso especificado en la base de datos.
     *
     * @param  \App\Models\Product  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el producto
        $producto = Producto::findOrfail($id);
        //Eliminamos el producto
        $producto->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Product eliminado con exito'
        ], Response::HTTP_OK);
    }
}
