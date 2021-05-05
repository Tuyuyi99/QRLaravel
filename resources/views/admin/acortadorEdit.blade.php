@extends("layouts/master")
@section('title', 'Panel Principal')
@section('content')

<form action="{{ route('acortador.update', ['id' => $acortador->id]) }}" method="POST">
    @csrf
    <span>Enlace:</span>
    <input type="text" name="link" value="{{ $acortador->link }}">
    <input type="hidden" name="codigo" value="{{ $acortador->codigo }}">
    <button class="btn btn-success" type="submit">Generar link corto</button>
    <select name="id_qr">
        @if (isset($qrList))
            @foreach ($qrList as $qr)
                @if ($qr->id == $acortador->id_qr)
                    <option value="{{ $qr->id }}" selected>{{ $qr->nombre }}</option>
                @else
                    <option value="{{ $qr->id }}">{{ $qr->nombre }}</option>
                @endif
            @endforeach
         @endif
    </select>
@method("PATCH")
@endsection