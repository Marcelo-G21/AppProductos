<?php

namespace App\Http\Controllers;

use App\Models\Componente_Sucursal;
use App\Models\Componente;
use App\Models\Sucursal;
use Illuminate\Http\Request;


class ComponenteSucursalController extends Controller
{

    public function index($idS, $idC)
    {   
        $componenteSucursal = Componente_Sucursal::where('id_componente', $idC)->where('id_sucursal', $idS)->first();
        
    
        return view('componentesSucursal.editar')
            ->with(
                array(
                    'componenteSucursal' => $componenteSucursal
                )
            );
    }

    public function agregar($id)
    {
        $sucursal = Sucursal::find($id);
        $componentes = Componente::all();
        return view('componentesSucursal.agregar')
            ->with(
                array(
                    'componentes' => $componentes,
                    'sucursal' =>  $sucursal
                )
            );
    }
    public function guardar(Request $request)
    {
        $validateData = $this->validate($request, [
            'id_componente' => 'required',
            'stock' => 'integer'
        ]);
        $idC = $request->input('id_componente');
        $idS = $request->input('id_sucursal');
        $componentesSucursal = Componente_Sucursal::where('id_componente', $idC)->where('id_sucursal', $idS)->get();
        if ($componentesSucursal->isEmpty()) {
            $componenteSucursal = new Componente_Sucursal();
            $componenteSucursal->id_sucursal = $request->input('id_sucursal');
            $componenteSucursal->id_componente = $request->input('id_componente');
            $componenteSucursal->stock = $request->input('stock');
            $message = "Componente agregado correctamente";
            $componenteSucursal->save();

            $componentesSucursal = Componente_Sucursal::where('id_sucursal', $componenteSucursal->id_sucursal)->get();
            $componentes = Componente::all();
            $sucursales = Sucursal::find($componenteSucursal->id_sucursal);
            return view('componentesSucursal.listar')
                ->with(
                    array(
                        'messageAdd' => $message,
                        'componentes' => $componentes,
                        'componentesSucursal' => $componentesSucursal,
                        'sucursal' =>  $sucursales
                    )
                );
        }else{
            $message = "Componente ya se encuentra registrado en la sucursal";
            $componentesSucursal = Componente_Sucursal::where('id_sucursal', $request->input('id_sucursal'))->get();
            $componentes = Componente::all();
            $sucursales = Sucursal::find($request->input('id_sucursal'));
            return view('componentesSucursal.listar')
                ->with(
                    array(
                        'messageError' => $message,
                        'componentes' => $componentes,
                        'componentesSucursal' => $componentesSucursal,
                        'sucursal' =>  $sucursales
                    )
                );
        }
    }
    public function listar($id)
    {
        $componentesSucursal = Componente_Sucursal::where('id_sucursal', $id)->get();
        $sucursal = Sucursal::find($id);
        /* dd($sucursal); */
        /* dd($componentesSucursal); */
        if ($componentesSucursal->isEmpty()) {
            $componentesSucursal = null;
            $message = 'La sucursal ' . $sucursal->nombre . ' no posee productos';

            return view('componentesSucursal.listar')
                ->with(
                    array(
                        'sucursal' => $sucursal,
                        'messageError' => $message,
                        'componentesSucursal' => $componentesSucursal
                    )
                );
        } else {
            return view('componentesSucursal.listar')
                ->with(
                    array(
                        'sucursal' => $sucursal,
                        'componentesSucursal' => $componentesSucursal
                    )
                );
        }
    }

    public function editComponente(Request $request)
    {
        $validateData = $this->validate($request, [
            'id_componente' => 'required',
            'stock' => 'integer | required'
        ]);
        $idC = $request->input('id_componente');
        $idS = $request->input('id_sucursal');
        $sucursal = Sucursal::find($idS);
        $componentesSucursal = Componente_Sucursal::where('id_componente', $idC)->where('id_sucursal', $idS)->first();
        $componentesSucursal->stock = $request->input('stock');
        $componentesSucursal->save();
        $message = "Stock editado correctamente";

        $componentesSucursal = Componente_Sucursal::where('id_sucursal', $idS)->get();
        return view('componentesSucursal.listar')
            ->with(
                array(
                    'sucursal' => $sucursal,
                    'messageEdit' => $message,
                    'componentesSucursal' => $componentesSucursal
                )
            );
    }

    public function deleteComponente($idS, $id)
    {
        $sucursal = Sucursal::find($idS);
        $componentesSucursal = Componente_Sucursal::find($id);
        $componentesSucursal->delete();
        $message = "Componente eliminado correctamente";


        $componentesSucursal = Componente_Sucursal::where('id_sucursal', $idS)->get();
        return view('componentesSucursal.listar')
            ->with(
                array(
                    'sucursal' => $sucursal,
                    'messageError' => $message,
                    'componentesSucursal' => $componentesSucursal
                )
            );
    }
}
