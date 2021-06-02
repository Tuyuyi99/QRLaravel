@extends("layouts/main")
@section("title", "Vista Principal")
@section("content")

<div class="container center">

  @if($qrList->isEmpty())
    <div style="color: red; margin-bottom: 10px;">
      {{ $mensaje }}
    </div>
  @else

    <div class="buscador divBuscador">
      <label><i class="fa fa-search" style="margin-right: 3px"></i></label>
      <input type="text" class="buscadorInput" id="texto" size="60" name="texto" placeholder="Escribe lo que buscas">  
    </div>

    <div>
      <form action="{{ route('qr.filtrar') }}">
        <select name="idServicio">
        @foreach ($serviciosListQr as $servicio)     
          <option value="{{ $servicio->id }}">{{ $servicio->servicio }}</option>
        @endforeach
        <input class="button selectButton" type="submit" value="Filtrar por servicio">
        </select> <br>
      </form>
    </div>

    <p id="resultados">
      {{-- Me traigo los resultados desde la vista qrBuscador --}}
    </p>

    <div id="ocultarEnBusqueda">

    @if (isset($qrList))
      @foreach ($qrList as $qr)
      <div class="saltopagina">
          <h3> Nombre: <span class="atributo">{{ $qr->nombre }}</span><input disabled type="text" size="40" name="nombre" value="{{ $qr->nombre }}" class="borde"></h3>
          <h3 style="display: inline;"> Fecha y hora de creación: </h3>
          {{ $qr->created_at }}<br>
          @if ($qr->enlace == NULL)
            <h3> Documento: <span class="atributo">{{ $qr->documento }} </span> <input disabled name="enlace" type="text" value="{{ $qr->documento }}" size="150" class="borde"></h3>
          @else
            <h3> Enlace: <span class="atributo">{{ $qr->enlace }} </span> <input disabled name="enlace" type="text" value="{{ $qr->enlace }}" size="150" class="borde"></h3>
          @endif


          <h3>Servicio seleccionado: <br>

          
            @if (isset($serviciosListQr))
                @foreach ($serviciosListQr as $servicio)
                  @if ($servicio->id == $qr->id_servicio)
                    <span class="servicio">{{ $servicio->servicio }}</span> </h3>
                  @endif
                @endforeach
            @endif
        </select>
        <button class="imprimir" onclick="window.print()">Imprimir</button>
          
        @if ($qr->enlace == NULL)
              
          <div id="imprimir" class="qr">{{ QrCode::size(300)      
          ->generate(route('acortar.linkDocumento', $qr->codigo)) }} </div>

          <a class="button shortlink" href="{{ route('acortar.linkDocumento', $qr->codigo) }}" target="_blank"> <i class="fa fa-link"></i>
          {{ route('acortar.linkDocumento', $qr->codigo) }} </a> <br>
        @else

          <div class="qr">{{ QrCode::size(300)      
          ->generate(route('acortar.linkEnlace', $qr->codigo)) }} </div>

          <a class="button shortlink" href="{{ route('acortar.linkEnlace', $qr->codigo) }}" target="_blank"> <i class="fa fa-link"></i>
          {{ route('acortar.linkEnlace', $qr->codigo) }} </a> <br>
        @endif
        <hr style="border:1px solid black;">
        </div>
        @endforeach
      </div>
    @endif
    <br>
  @endif
</div>
@endsection