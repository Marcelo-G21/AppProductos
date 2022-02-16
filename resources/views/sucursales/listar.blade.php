@extends('layouts.app')

@section('content')

<style>
    .headcomp {
        color: #989797;
        text-shadow: 1px 2px 0 #7D6666;
    }

    .card {
        box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -webkit-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -moz-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
    }
</style>
<div class="container">
    <div class="row py-5 ">
        <div class="col-lg-5 m-auto text-center">
            <h1 class="headcomp">SUCURSALES</h1>
        </div>

    </div>
    @if(isset($messageError))
    <div class="alert alert-danger">
        {{ $messageError }}
    </div>
    @elseif(isset($messageAdd))
    <div class="alert alert-success">
        {{ $messageAdd }}
    </div>
    @elseif(isset($messageEdit))
    <div class="alert alert-primary">
        {{ $messageEdit }}
    </div>
    @endif

    <div class="d-flex justify-content-end">
        <a class="btn btn-sm btn-success" href="{{url('/agregarSucursales')}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg> Agregar sucursal</a>
    </div>
    @if(isset($sucursales))
    @php
    dd($sucursales)
    @endphp
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @foreach($sucursales as $sucursal)
                        <div class="col-3">
                            <div class="card m-3" style="max-width: 540px; min-height: 160px;">
                                <div class="row g-0">
                                    <div class="col-md-8">
                                        <div class="card-body" style="min-height: 112px;">
                                            <h5 class="card-title">{{ $sucursal->nombre }}</h5>
                                            @if($sucursal->created_at < $sucursal->updated_at)
                                                <p class="card-text"><small class="text-muted">{{ App\Helpers\FormatTime::LongTimeUpdate($sucursal->updated_at) }}</small></p>
                                                @else
                                                <p class="card-text"><small class="text-muted">{{ App\Helpers\FormatTime::LongTimeFilter($sucursal->created_at) }}</small></p>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="card-footer" style="min-height: 49px; text-align: center;">
                                        <a href="#eliminarModal{{$sucursal->id}}" role="button" class="btn btn-sm btn-danger" data-toggle="modal"> <i class="far fa-trash-alt"></i> </a>
                                        <a href="#editarModal{{$sucursal->id}}" role="button" class="btn btn-sm btn-warning" data-toggle="modal"><i style="color: white;" class="fas fa-edit"></i></a>
                                        <a href="{{ url('listarComponenteSucursal/'.$sucursal->id) }}" type="button" class="btn btn-success btn-sm btn-rounded">Ver componentes</a>
                                        <!-- Modal / Ventana / Overlay en HTML -->
                                        <div id="eliminarModal{{$sucursal->id}}" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Seguro que quieres borrar la sucursal {{ $sucursal->nombre }}?</p>
                                                        <p><small>Si lo borras, nunca podrás recuperarlo.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <a href="{{ url('eliminarSucursal/'.$sucursal->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="editarModal{{$sucursal->id}}" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Seguro que quieres editar la sucursal {{ $sucursal->nombre }}?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <a href="{{ url('editarSucursal/'.$sucursal->id) }}" type="button" class="btn btn-warning">Editar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    @endif
</div>
@endsection