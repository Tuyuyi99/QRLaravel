@extends("layouts/master")
@section("title", "Vista Principal")
@section("content")

<div class="container" style="text-align: center;">

  <a class="button addbutton" href="{{ route('qr.create') }}">Nuevo</a> 
  

  @foreach ($qrList as $qr)
    <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
      @method("PATCH")
      @csrf
      <h3>Nombre: <input id="nombre" size="40" type="text" name="nombre" value="{{ $qr->nombre }}"
      style="border:none; border-bottom:solid 1px;"></h3>

      <h3>Enlace: <input type="text" name="enlace"
      value="{{ $qr->enlace }}" size="150" style="border:none; border-bottom:solid 1px;"></h3>
      

      <button class ="button modifybutton" type="submit">Modificar</button>

      <div class="qr">{{ QrCode::size(300)      
        ->generate(route('acortar.link', $qr->codigo)) }} </div>

        

        <a class="button shortlink" href="{{ route('acortar.link', $qr->codigo) }}" target="_blank">
        {{ route('acortar.link', $qr->codigo) }} </a> <br>
        

        <a class="button editbutton" href="{{ route('qr.edit', $qr->id) }}">Editar</a>
        
        
      </form>
      <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
        @csrf
        @method("DELETE")
        <button class="button deletebutton" onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar</button>
        <hr style="border:1px solid black;">
    </form>
@endforeach
</div>
@endsection