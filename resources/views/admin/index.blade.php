@extends("layouts/master")
@section("title", "Panel Principal")
@section("content")

<div class="container">

  <a href="{{ route('qr.create') }}">Nuevo</a> <br>
  <a href="{{ route('acortador.create') }}">Acortar enlace</a>

@foreach ($acortadorListQr as $acortadorLink)
  @foreach ($qrList as $qr) 
  @if ($acortadorLink->id_qr == $qr->id)
  <br>
   {{QrCode::size(200)
   ->generate(route('acortar.link', $acortadorLink->codigo))}}

      <a href="{{ route('acortador.edit', $acortadorLink->id) }}">Editar</a>
    </form>
    <form action="{{ route('qr.destroy', $qr->id) }}" method="POST">
      @csrf
      @method("DELETE")
      <button onclick="return confirm('¿Seguro que quieres eliminarlo?')" type="submit">Borrar</button>
      <a href="{{ route('acortar.link', $acortadorLink->codigo) }}" target="_blank">{{ route('acortar.link', $acortadorLink->codigo) }}</a>
  </form>
  @endif
  @endforeach

@endforeach 
</div>

@endsection