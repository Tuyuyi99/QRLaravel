@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")


@if (count($servicios))
<b style="color:red">Resultados de la búsqueda:</b> <br>
    @foreach ($nombres as $nombre)
        @foreach ($servicios as $item)
            @if ($item->id == $nombre->id_servicio)
                <b>Nombre: </b> {{$nombre->nombre}} <br>
                <b> Fecha y hora de creación: </b> {{ $nombre->created_at }}<br>
                <b>Servicio: </b> {{ $item->servicio }} <br>
                @if ($nombre->enlace == NULL)
                    <b>Documento: </b> {{ $nombre->documento }}<br>
                    <b>Código QR: </b> {{ QrCode::size(200)      
                    ->generate(route('acortar.linkDocumento', $nombre->codigo)) }}
                @else
                    <b>Enlace: </b> {{ $nombre->enlace }}<br>
                    <b>Código QR: </b> {{ QrCode::size(200)      
                        ->generate(route('acortar.linkEnlace', $nombre->codigo)) }}
                @endif
                <hr class="separador">
            @endif
        @endforeach
    @endforeach
  @endif

