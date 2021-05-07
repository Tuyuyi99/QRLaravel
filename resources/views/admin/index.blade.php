@extends("layouts/master")
@section("title", "Vista Principal")
@section("content")

<div class="container">

  <a href="{{ route('qr.create') }}">Nuevo</a> <br>
  <br>

  @foreach ($qrList as $qr)
    <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
      @method("PATCH")
      @csrf
      <h3>Nombre: <input id="nombre" size="40" type="text" name="nombre" value="{{ $qr->nombre }}"
      size="10" style="border:none; border-bottom:solid 1px;"></h3>

      <h3>Enlace:<input type="text" name="enlace"
      value="{{ $qr->enlace }}" size="80" style="border:none; border-bottom:solid 1px;">
      <br>

      <button type="submit">Modificar</button><br>

      {{ QrCode::size(200)      
        ->generate(route('acortar.link', $qr->codigo)) }}

        <br>

        <a href="{{ route('acortar.link', $qr->codigo) }}" target="_blank">{{ route('acortar.link', $qr->codigo) }}</a> 
        <br>

        <a href="{{ route('qr.edit', $qr->id) }}">Editar</a>
      </form>
      <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
        @csrf
        @method("DELETE")
        <button onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar</button>
        <br>
    </form>
@endforeach
</div>
@endsection