@extends("layouts/master")
@section("title", "Panel Principal")
@section("content")

<div class="container">

  <a href="{{ route('qr.create') }}">Nuevo</a>
  
  @foreach ($QrList as $qr)
    <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
      @method("PATCH")
      @csrf
      <h3>Nombre: <input id="nombre" type="text" name="nombre" value="{{ $qr->nombre }}"
      size="10" style="border:none; border-bottom:solid 1px;"></h3>

      <h3>Enlace: <input type="text" name="enlace"
      value="{{ $qr->enlace }}" size="30" style="border:none; border-bottom:solid 1px;">
      </h3>
      <button type="submit">Modificar</button>
    </form>
   {{QrCode::size(200)->generate($qr->enlace)}}
      <a href="{{ route('qr.edit', $qr->id) }}">Editar</a>
    </form>
    <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
      @csrf
      @method("DELETE")
      <button onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar</button>
  </form>
  @endforeach
</div>
@endsection