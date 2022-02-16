@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Str;

$uniqid = Str::random(6);
?>

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
                    Registrar Componente
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
                    <form method="POST" action="{{url('/guardarComponenteSucursal')}}">
                        @csrf
                        <input type="hidden" name="id_sucursal" value="{{$sucursal->id}}">
                        <div class="form-group row mb-3">
                            <label for="id_componente" class="col-md-4 col-form-label text-md-right">
                                Seleccione componente
                            </label>
                            <div class="col-md">
                                <select class="form-control" name="id_componente" autofocus>
                                    <option selected disabled>Seleccione el componente</option>
                                    @foreach($componentes as $componente)
                                    <option value="{{$componente->id}}"> {{$componente->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">
                                Stock
                            </label>
                            <div class="col-md">
                                <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" autofocus>
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