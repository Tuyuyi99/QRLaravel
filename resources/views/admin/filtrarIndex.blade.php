@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")


@if (isset($servicios))
    <div class="container" style="text-align: center;">
        <input type="text" size="50" id="texto" name="texto" placeholder="Buscador"> <br><br>
        <p id="resultados"> </p>
        <div id="ocultarEnBusqueda">
        @foreach ($servicios as $servicio)
            @foreach ($idServicios as $idServicio)
                @if ($servicio->id == $idServicio->id_servicio)
                    <b>Nombre: </b> {{$idServicio->nombre}}<br>
                    <b> Fecha y hora de creación: </b> {{ $idServicio->created_at }}<br>
                    <b>Servicio: </b> {{ $servicio->servicio }} <br>
                    @if ($idServicio->enlace == NULL)
                        <b>Documento: </b> {{ $idServicio->documento }}<br>
                        <b>Código QR: </b> {{ QrCode::size(200)      
                        ->generate(route('acortar.linkDocumento', $idServicio->codigo)) }}
                    @else
                        <b>Enlace: </b> {{ $idServicio->enlace }}<br>
                        <b>Código QR: </b> {{ QrCode::size(200)      
                        ->generate(route('acortar.linkEnlace', $idServicio->codigo)) }}
                    @endif
                    <hr class="separador">
                @endif
            @endforeach  
        @endforeach
        </div>
        <img src="{{ url("assets/img/sas.png") }}" alt="Logo del SAS">
    </div>
@endif