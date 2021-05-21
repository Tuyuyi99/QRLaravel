@extends("layouts/master")
@section("title", "Vista Principal")
@section("content")

<div class="container" style="text-align: center;">

  @if (isset($serviciosList))
    <a class="button addbutton" href="{{ route('servicio.create') }}">Nuevo Servicio <i class="fas fa-plus-circle"></i></i></a>
      @foreach ($serviciosList as $servicio)
        <form action="{{ route('servicio.update', ['id' => $servicio->id]) }}" method="POST">
          @method("PATCH")
          @csrf
          <h3>Nombre del servicio: <input id="servicio" size="40" type="text" name="servicio" value="{{ $servicio->servicio }}"
          style="border:none; border-bottom:solid 1px;"></h3>

          <button class ="button modifybutton" type="submit">Modificar <i class="far fa-save"></i></button>

          <a class="button editbutton" href="{{ route('servicio.edit', $servicio->id) }}">Editar <i class="fa fa-edit"></i></a>

        </form>
        <form action="{{ route('servicio.destroy', $servicio->id) }}" method="POST">
          @csrf
          @method("DELETE")
          <button class="button deletebutton" onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar <i class="fa fa-trash-alt"></i></button>
          <hr style="border:1px solid black;">
        </form>
      @endforeach
  @endif

  @if (isset($qrList))
  <a class="button addbutton" href="{{ route('qr.createDocumento') }}">Nuevo QR (Subir Documento) <i class="fas fa-plus-circle"></i></i></a>
  <a class="button addbutton" href="{{ route('qr.createEnlace') }}">Nuevo QR (Enlace) <i class="fas fa-plus-circle"></i></i></a> <br>

  <input type="text" id="texto" name="texto" placeholder="Buscador"> <br>
    <b id="resultados">
    </b> <br>

    {{-- Filtrar por Servicio: 
    <select name="id_servicio">
      @if (isset($serviciosListQr))
          @foreach ($serviciosListQr as $servicio)
            @if ($servicio->id == $qrList)
              <option>{{ $servicio->servicio }}</option>
            @endif
          @endforeach
      @endif
  </select> --}}

    @foreach ($qrList as $qr)
      <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
        @method("PATCH")
        @csrf
        <h3>Nombre: <input size="40" type="text" name="nombre" value="{{ $qr->nombre }}"
        style="border:none; border-bottom:solid 1px;"></h3>
        @if ($qr->enlace == NULL)
          <h3>Documento: <input disabled type="text" name="enlace"
            value="{{ $qr->documento }}" size="150" style="border:none; border-bottom:solid 1px;"></h3>
        @else
          <h3>Enlace: <input type="text" name="enlace"
          value="{{ $qr->enlace }}" size="150" style="border:none; border-bottom:solid 1px;"></h3>
        @endif


        <h3>Servicio seleccionado: </h3>

        <select name="id_servicio">
          @if (isset($serviciosListQr))
              @foreach ($serviciosListQr as $servicio)
                @if ($servicio->id == $qr->id_servicio)
                  <option value="{{ $servicio->id }}" selected>{{ $servicio->servicio }}</option>
                @else
                  <option value="{{ $servicio->id }}">{{ $servicio->servicio }}</option>
                @endif
              @endforeach
          @endif
      </select>
      <button onClick="window.print()">Imprimir</button>

      @if ($qr->enlace == NULL)
            
        <div class="qr">{{ QrCode::size(500)      
        ->generate(route('acortar.linkDocumento', $qr->codigo)) }} </div>

        <a class="button shortlink" href="\\127.0.0.1:8000\Users\CuestaPablo85W\Desktop\laravel-qr-code\public\assets\documentos\Farmacia\2021-05-21 11-29-55 - Cuaderno de prácticas Pablo De La Cuesta Espinosa plantilla.pdf" target="_blank"> <i class="fa fa-link"></i>
        {{ route('acortar.linkDocumento', $qr->codigo) }} </a> <br>
      @else
        <button class ="button modifybutton" type="submit">Modificar <i class="far fa-save"></i></button>

        <div class="qr">{{ QrCode::size(500)      
        ->generate(route('acortar.linkEnlace', $qr->codigo)) }} </div>

        <a class="button shortlink" href="{{ route('acortar.linkEnlace', $qr->codigo) }}" target="_blank"> <i class="fa fa-link"></i>
        {{ route('acortar.linkEnlace', $qr->codigo) }} </a> <br>
        <a class="button editbutton" href="{{ route('qr.edit', $qr->id) }}">Editar <i class="fa fa-edit"></i></a>
      @endif
          

     
          
          
      </form>
      <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
        @csrf
        @method("DELETE")
        <button class="button deletebutton" onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar <i class="fa fa-trash-alt"></i></button>
        <hr style="border:1px solid black;">
      </form>
      @endforeach
  @endif
</div>
@endsection