@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")


@if (isset($servicios))
    <div class="container" style="text-align: center;">
        <input type="text" size="50" id="texto" name="texto" placeholder="Buscador"> <br><br>
        <b id="resultados"> </b>
        <div id="ocultarEnBusqueda">
        @foreach ($servicios as $servicio)
            @foreach ($idServicios as $idServicio)
                @if ($servicio->id == $idServicio->id_servicio)
                    <b>Nombre: </b> {{$idServicio->nombre}}<br>
                    <b> Fecha y hora de creación: </b> {{ $idServicio->created_at }}<br>
                    <b>Servicio: </b> {{ $servicio->servicio }} <br>
                <b>Código QR:</b> {{ QrCode::size(150)      
                    ->generate(route('acortar.linkDocumento', $idServicio->codigo)) }}
                    <hr>
                @endif
            @endforeach  
        @endforeach
        </div>
        <img src="{{ url("assets/img/sas.png") }}" alt="Logo del SAS">
    </div>
@endif