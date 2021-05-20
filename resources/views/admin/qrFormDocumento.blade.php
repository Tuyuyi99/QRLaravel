@extends("layouts/form")
@section('title', 'Editar o Nuevo QR')
@section('content')

    <form action="{{ route('qr.subirDocumento') }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre:</span>
            <input type="text" name="nombre">

            <span>Subir documento:</span>
            <input type="file" name="documento[]" multiple>

                Servicio: <select name="id_servicio">
                @if (isset($serviciosList))
                    @foreach ($serviciosList as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->servicio }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        @csrf
        <input type="submit" value="Crear">
    </form>    
@endsection
