@extends('layouts.app')
<style>
    img {
        position: static;
        box-shadow: #1b1f24;
        border-block: inherit;
        border-color: whitesmoke;
        padding: 10%;
        max-height: 14rem;
        color: #fff;
    }

    p {
        margin-top: 15px;
        font-size: 1.1rem;
        line-height: 1.4;
        text-align: center;
        font-style: italic;
    }

    h4 {
        color: turquoise;
        font-style: italic;
        font-weight: 600;
        height: 3rem;
    }

    .card-img {
        min-height: 240px;
    }

    .headcomp {
        color: #989797;
        text-shadow: 1px 2px 0 #7D6666;
    }

    .card-body{
        height: 14rem;
    }
    .contenedor {
        min-height: 500px;
        border-radius: 20px;
        background-color: white;
        box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -webkit-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
        -moz-box-shadow: 8px 10px 16px -4px rgba(0, 0, 0, 0.78);
    }

    .contenedor:hover {
        transform: translateY(-15px);
        transition: transform .3s;
    }

</style>
@section('content')
<div class="container">
    
    <div class="row py-5 ">
        <div class="col-lg-5 m-auto text-center">
            <h1 class="headcomp">COMPONENTES</h1>
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
        <a class="btn btn-sm btn-success" href="{{url('/agregar')}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg> Agregar componente</a>
    </div>
    @if(isset($componentes))
    <div class="row ms-auto me-auto">
        @foreach($componentes as $componente)
        <div class="col-3 text-center mt-4 mb-4">
            <div class="contenedor">
                <div class="card-img">
                    @if(Storage::disk('imagenes')->has($componente->imagen))
                    <img src="{{ url('miniatura/'.$componente->imagen) }}" class="img-fluid rounded-start" width="400" height="450" alt="...">
                    @endif
                </div>
                <div class="card-body">
                    <div class="">
                        <h4>{{$componente->nombre}}</h4>
                        <p><b>${{$componente->precio}}</b></p>
                        <p>{{$componente->descripcion}}</p>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="#eliminarModal{{$componente->id}}" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>
                    <a href="#editarModal{{$componente->id}}" role="button" class="btn btn-warning" data-toggle="modal">Editar</a>
                </div>
            </div>
        </div>
        <!-- Modal / Ventana / Overlay en HTML  -->
        <div id="eliminarModal{{$componente->id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">¿Estás seguro?</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro que quieres borrar el componente {{ $componente->nombre }}?</p>
                        <p><small>Si lo borras, nunca podrás recuperarlo.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="{{ url('eliminarComponente/'.$componente->id) }}" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="editarModal{{$componente->id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">¿Estás seguro?</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro que quieres editar el componente {{ $componente->nombre }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <a href="{{ url('editarComponente/'.$componente->id) }}" type="button" class="btn btn-warning">Editar</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="d-flex justify-content-end">
            {{ $componentes->links() }}
        </div>
    </div>
    @endif
</div>
@endsection