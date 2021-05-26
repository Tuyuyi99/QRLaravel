@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")


@if (count($servicios))
<b style="color:red">Resultados de la búsqueda:</b> <br>
    @foreach ($qrs as $qr)
        @foreach ($servicios as $servicio)
            @if ($servicio->id == $qr->id_servicio)
                <b>Nombre: </b> {{$qr->nombre}} <br>
                <b> Fecha y hora de creación: </b> {{ $qr->created_at }}<br>
                <b>Servicio: </b> {{ $servicio->servicio }} <br>
                @if ($qr->enlace == NULL)
                    <b>Documento: </b> {{ $qr->documento }}<br>
                    <b>Código QR: </b> {{ QrCode::size(200)      
                    ->generate(route('acortar.linkDocumento', $qr->codigo)) }}
                @else
                    <b>Enlace: </b> {{ $qr->enlace }}<br>
                    <b>Código QR: </b> {{ QrCode::size(200)      
                        ->generate(route('acortar.linkEnlace', $qr->codigo)) }}
                @endif
                <hr class="separador">
            @endif
        @endforeach
    @endforeach
  @endif

