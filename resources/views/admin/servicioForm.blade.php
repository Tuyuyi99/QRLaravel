@extends("layouts/form")
@section('title', 'Editar o Nuevo Servicio')
@section('content')

@isset($servicio)
    <form action="{{ route('servicio.update', ['id' => $servicio->id]) }}" method="POST">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre del servicio:</span>
            <input type="text" name="servicio" value="{{ $servicio->servicio }}">
        </div>
        @method("PATCH")
    @else

    <form action="{{ route('servicio.store') }}" method="POST">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre del servicio:</span>
            <input type="text" name="servicio">                  
        </div>
        @endisset
        @csrf
        <input type="submit" value="Crear">
    </form>    
@endsection