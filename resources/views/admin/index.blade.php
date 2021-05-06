@extends("layouts/master")
@section("title", "Panel Principal")
@section("content")

<div class="container">

  <a href="{{ route('qr.create') }}">Nuevo</a> <br>

  @foreach ($qrList as $qr)
  <br>

  <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
    @method("PATCH")
    @csrf
    <h3>Nombre: <input id="nombre" type="text" name="nombre" value="{{ $qr->nombre }}"
    size="10" style="border:none; border-bottom:solid 1px;"></h3>

    <button type="submit">Modificar nombre</button>

    <h3>Enlace seleccionado: <input readonly type="text" name="enlace"
    value="{{ $qr->enlace }}" size="80" style="border:none; border-bottom:solid 1px;">
    <br>

    {{ QrCode::size(200)      
      ->generate(route('acortar.link', $qr->codigo)) }}

      <br>
      <a href="{{ route('acortar.link', $qr->codigo) }}" target="_blank">{{ route('acortar.link', $qr->codigo) }}</a> <br>
      <a href="{{ route('acortador.edit', $qr->id) }}">Editar enlace a redireccionar</a>
    </form>
    <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
      @csrf
      @method("DELETE")
      <button onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar todo</button>
      <br>
  </form>

@endforeach
</div>

@endsection