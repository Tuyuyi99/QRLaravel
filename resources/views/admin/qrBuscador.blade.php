@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")

@if (count($servicios))
    @foreach ($servicios as $item)
        @foreach ($nombres as $nombre)
        Nombre: {{$nombre->nombre}} <br>
        Servicio : {{ $item->servicio }} <br>
        Código QR: {{ QrCode::size(200)      
            ->generate(route('acortar.linkDocumento', $nombre->codigo)) }}
            <hr>
            @endforeach
    @endforeach
  @endif