@extends("layouts/master")
@section('title', 'Panel Principal')
@section('content')


<form method="POST" action="{{ route('acortador.store') }}">
@csrf
    <input type="text" name="link" value="{{ $qrList->first()->enlace}}">
    <button class="btn btn-success" type="submit">Generar link corto</button>

    <select name="id_qr">
        @if (isset($qrList))
            @foreach ($qrList as $qr)
                <option value="{{ $qr->id }}">
                {{ $qr->nombre }}</option>
            @endforeach
        @endif
    </select>
</form>
@endsection