@extends("layouts/form")
@section("title", "Vista Principal")
@section("content")

@if (count($servicios))
    @foreach ($nombres as $nombre)
        @foreach ($servicios as $item)
            @if ($item->id == $nombre->id_servicio)
                Nombre: {{$nombre->nombre}} <br>
                Servicio : {{ $item->servicio }} <br>
                Código QR: {{ QrCode::size(200)      
                ->generate(route('acortar.linkDocumento', $nombre->codigo)) }}
                <hr>
            @endif
        @endforeach
    @endforeach
  @endif
