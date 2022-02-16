@extends('layouts.app')

@section('content')


<style>
    .card {
        box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -webkit-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -moz-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="row py-5 ">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-center" style="color:white; font-size: 1.5rem;">
                    Editar Componente
                </div>
                @if($errors->any())
                <div class="alert alert-danger m-2">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{url('/actualizarComponenteSucursal')}}">
                        @csrf
                        <input type="hidden" name="id_componente" value="{{$componenteSucursal->id_componente}}">
                        <input type="hidden" name="id_sucursal" value="{{$componenteSucursal->id_sucursal}}">
                        <div class="form-group row mb-3">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">
                                Componente:
                            </label>
                            <div class="col-md">
                                <input type="text" class="form-control" readonly value="{{$componenteSucursal->componente->nombre}}">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">
                                Stock
                            </label>
                            <div class="col-md">
                                <input type="number" class="form-control" name="stock" value="{{$componenteSucursal->stock}}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row  mt-4 mb-0" style="margin: .1rem;">
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection 
