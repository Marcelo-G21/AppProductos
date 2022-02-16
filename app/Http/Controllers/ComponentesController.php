<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

use App\Models\Componente;
use App\Models\Componente_Sucursal;
use App\Models\TipoComponente;

class ComponentesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {
        $tiposComponente = TipoComponente::all();
        $componente = Componente::find($id);
        return view('productos.editar')
            ->with(
                array(
                    'tiposComponente' => $tiposComponente,
                    'componente' => $componente
                )
            ); 
    }

    public function listar()
    {
        $componentes = Componente::paginate(4);
        if ($componentes->isEmpty()) {
            $message = 'No existen componentes, favor agregar';
            $componentes = null;
            return view('productos.listar')
                ->with(array(
                    'messageEdit' => $message,
                    'componentes' => $componentes
                ));
        }
        return view('productos.listar')
            ->with('componentes', $componentes);
    }

    public function agregar()
    {
        $tipoComponentes = TipoComponente::all();
        return view('productos.agregar')
            ->with('tipoComponentes', $tipoComponentes);
    }
    public function guardar(Request $request)
    {

        $validateData = $this->validate($request, [
            'nombre' => 'required|min:3',
            'precio' => 'integer',
            'imagen' => 'required',
            'descripcion' => 'required',
            'idTipo_componente' => 'required',
        ]);
        $componente = new Componente();
        $componente->unique_code = $request->input('unique_code');
        $componente->nombre = $request->input('nombre');
        $componente->precio = $request->input('precio');
        $componente->descripcion = $request->input('descripcion');
        $componente->idTipo_componente = $request->input('idTipo_componente');



        //cargar Imagen
        $imagen = $request->file('imagen');
        if ($imagen) {
            $imagen_path = time() . '-' . $imagen->getClientOriginalName();
            \Storage::disk('imagenes')->put($imagen_path, \File::get($imagen));
            $componente->imagen = $imagen_path;
        }
        $message = "Producto agregado correctamente";
        $componente->save();

        $componentes = Componente::paginate(4);

        return view('productos.listar')->with(
            array(
                'messageAdd' => $message,
                'componentes' => $componentes
            )
        );
    }

    public function getImagen($filename)
    {
        $file = \Storage::disk('imagenes')->get($filename);
        return new Response($file, 200);
    }

    public function deleteComponente($id)
    {
        $componente = Componente::find($id);
        $componentesSucursal = Componente_Sucursal::where('id_componente', $id)->get();
        if($componentesSucursal->isEmpty()){
            if ($componente) {
                //Eliminar Imagen
                \Storage::disk('imagenes')->delete($componente->imagen);
                $componente->delete();
                $message = "Componente eliminado correctamente";
            } else {
                $message = "El componente no fue eliminado";
            }
        }else{
            $message = 'El producto se encuentra ingresado en una sucursal, eliminar desde sucursal primero';
        }
        $componentes = Componente::paginate(4);
        return view('productos.listar')
            ->with(
                array(
                    'messageError' => $message,
                    'componentes' => $componentes
                )
            );
    }

    public function editComponente(Request $request)
    {
        $componente = Componente::find($request->id);

        $validateData = $this->validate($request, [
            'nombre' => 'required|min:3',
            'precio' => 'required',
            'descripcion' => 'required',
            'idTipo_componente' => 'required',
        ]);
        $componente->nombre = $request->nombre;
        $componente->precio = $request->precio;
        $componente->descripcion = $request->descripcion;
        $componente->idTipo_componente = $request->idTipo_componente;
        $imagen = $request->file('imagen');
        if ($imagen) {
            \Storage::disk('imagenes')->delete($componente->imagen);
            $imagen_path = time() . '-' . $imagen->getClientOriginalName();
            \Storage::disk('imagenes')->put($imagen_path, \File::get($imagen));
            $componente->imagen = $imagen_path;
        }
        $componente->save();


        $messageEdit = "Componente editado correctamente";
        $componentes = Componente::paginate(4);
        return view('productos.listar')->with(
            array(
                'messageEdit' => $messageEdit,
                'componentes' => $componentes
            )
        );
    }

    public function searchProduct($search = null)
    {
        if (is_null($search)) {
            $search = \Request::get('search');
            return redirect()->route(
                'buscarComponente',
                array(
                    'search' => $search
                )
            );
        }
        $componentes = Componente::where('nombre', 'like', '%' . $search . '%')->orwhere('unique_code', 'like', '%' . $search . '%')->paginate(4);
        if($componentes->count() == 0){
            $message = 'No se ha encontrado el producto';
            return view('productos.listar')
            ->with(
                array(
                    'messageEdit' => $message,
                    'componentes' => $componentes
                )
            );
        }else{
        return view('productos.listar')
            ->with(
                array(
                    'componentes' => $componentes
                )
            );
        }
    }
}
