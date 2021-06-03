@extends("layouts/master")
@section("title", "Vista Principal")
@section("content")

<div class="container" style="text-align: center;">

  @if(session()->has('message'))
  <div style="color: red">
      {{ session()->get('message') }}
  </div>
@endif

  @if (isset($serviciosList))
    <a class="button addbutton" href="{{ route('servicio.create') }}">Nuevo Servicio <i class="fas fa-plus-circle"></i></i></a>
      @foreach ($serviciosList as $servicio)
        <form action="{{ route('servicio.update', ['id' => $servicio->id]) }}" method="POST">
          @method("PATCH")
          @csrf
          <h3>Nombre del servicio: <input id="servicio" size="40" type="text" name="servicio" value="{{ $servicio->servicio }}"
          style="border:none; border-bottom:solid 1px;"></h3>

          <h3 style="display: inline;"> Fecha y hora de creación: </h3>
          {{ $servicio->created_at }}<br>

          @if (auth()->user()->rol_id == '1')
                @foreach($userListServicio as $usuario)
                    @if ($servicio->id_usuario == $usuario->id)
                        <div class="col-sm-4">
                            <h3 style="display: inline;"> Usuario creador: </h3><br>
                            {{ $usuario->name . ' ' . $usuario->surname }}<br>
                        </div>
                    @endif
                @endforeach
            @endif

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

  @if (isset($userList))
  @foreach ($userList as $user)
      <h3>{{ $user->name }}</h3>
      <form action="{{ route('user.destroy', $user->id) }}" method="POST">
          @csrf
          @method("DELETE")
          <button class="button deletebutton" onclick="return confirm('¿Seguro que quieres eliminarlo?')"
              type="submit">Borrar <i class="fa fa-trash-alt"></i></button>
      </form>
  @endforeach
  <hr style="border:2px solid black;"><br>
@endif

  @if (isset($qrList))

  @if($serviciosListQr->isEmpty())
    <div style="color: red; margin-bottom: 10px;">
      {{ $mensaje }}
    </div>
  @else

    <a class="button addbutton" href="{{ route('qr.createDocumento') }}">Nuevo QR (Subir Documento) <i class="fas fa-plus-circle"></i></i></a>
    <a class="button addbutton" href="{{ route('qr.createEnlace') }}">Nuevo QR (Enlace) <i class="fas fa-plus-circle"></i></i></a> <br>

    <div class="buscador divBuscador">
      <label><i class="fa fa-search" style="margin-right: 3px"></i></label>
      <input type="text" class="buscadorInput" id="texto" size="60" name="texto" placeholder="Escribe lo que buscas">  
    </div>

    <br>
    <br>

    <div>
      <form action="{{ route('qr.filtrar') }}">
        <select name="idServicio">
        @foreach ($serviciosListQr as $servicio)     
          <option value="{{ $servicio->id }}">{{ $servicio->servicio }}</option>
        @endforeach
        <input class="button selectButton" type="submit" value="Filtrar">
        </select> <br>
      </form>
    </div>

      <p id="resultados">
        {{-- Me traigo los resultados desde la vista qrBuscador --}}
      </p>

      <div id="ocultarEnBusqueda">

      @foreach ($qrList as $qr)
        <form action="{{ route('qr.updateEnlace', ['id' => $qr->id]) }}" method="POST">
          @method("PATCH")
          @csrf

          <h3 style="display: inline;"> Fecha y hora de creación: </h3>
          {{ $qr->created_at }}
          
          @if ($qr->enlace == NULL)
            <h3>Nombre: <input disabled size="40" type="text" name="nombre" value="{{ $qr->nombre }}"
            style="border:none; border-bottom:solid 1px;"></h3>

            <h3>Documento: <input disabled type="text" name="enlace"
              value="{{ $qr->documento }}" size="150" style="border:none; border-bottom:solid 1px;"></h3>

              <h3>Servicio seleccionado: </h3>

                @if (isset($serviciosListQr))
                    @foreach ($serviciosListQr as $servicio)
                      @if ($servicio->id == $qr->id_servicio)
                        {{ $servicio->servicio }}
                      @endif
                    @endforeach
                @endif

          @else
            <h3>Nombre: <input size="40" type="text" name="nombre" value="{{ $qr->nombre }}"
            style="border:none; border-bottom:solid 1px;"></h3>

            <h3>Enlace: <input type="text" name="enlace"
            value="{{ $qr->enlace }}" size="150" style="border:none; border-bottom:solid 1px;"></h3>

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
          @endif

          @if (auth()->user()->rol_id == '1')
          @foreach($userListQr as $usuario)
              @if ($qr->id_usuario == $usuario->id)
                  <div class="col-sm-4">
                      <h3 style="display: inline; text-align:center; border:none;"> Usuario creador: </h3><br>
                      <h5 style="color:gray">{{ $usuario->name }}</h5><br>
                  </div>
              @endif
          @endforeach
      @endif

        @if ($qr->enlace == NULL)
              
          <div class="qr">{{ QrCode::size(200)      
          ->generate(route('acortar.linkDocumento', $qr->codigo)) }} </div>

          <a class="button shortlink" href="{{ route('acortar.linkDocumento', $qr->codigo) }}" target="_blank"> <i class="fa fa-link"></i>
          {{ route('acortar.linkDocumento', $qr->codigo) }} </a> <br>
          <a class="button editbutton" href="{{ route('qr.editDocumento', $qr->id) }}">Editar <i class="fa fa-edit"></i></a>
        @else
          <button class ="button modifybutton" type="submit">Modificar <i class="far fa-save"></i></button>

            {{-- Generar QRs Estáticos (Ejemplo)

              {{ QrCode::size(100)->generate('https://www.formacionsspa.es/gesforma-sspa/') }} 

            --}}

          <div class="qr">{{ QrCode::size(200)      
          ->generate(route('acortar.linkEnlace', $qr->codigo)) }} </div>

          <a class="button shortlink" href="{{ route('acortar.linkEnlace', $qr->codigo) }}" target="_blank"> <i class="fa fa-link"></i>
          {{ route('acortar.linkEnlace', $qr->codigo) }} </a> <br>
          <a class="button editbutton" href="{{ route('qr.editEnlace', $qr->id) }}">Editar <i class="fa fa-edit"></i></a>
        @endif
            
        </form>
        <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
          @csrf
          @method("DELETE")
          <button class="button deletebutton" onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar <i class="fa fa-trash-alt"></i></button>
          <hr style="border:1px solid black;">
        </form>
      @endforeach
      </div>
    @endif
    <br>
  @endif
</div>
@endsection