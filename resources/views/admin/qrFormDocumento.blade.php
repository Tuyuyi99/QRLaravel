@extends("layouts/form")
@section('title', 'Editar o Nuevo QR')
@section('content')

@isset($qr)
<h3>Atención, si se quiere editar el servicio, Debe de volver a subirse el documento.</h3>
    <form action="{{ route('qr.updateDocumento', ['id' => $qr->id]) }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre:</span>
            <input type="text" name="nombre" value="{{ $qr->nombre }}">

            <span>Subir documento:</span>
            <input type="file" name="documento[]" value="{{ $qr->documento }}">

            Servicio: <select name="id_servicio">
                @if (isset($serviciosList))
                    @foreach ($serviciosList as $servicio)
                        @if ($servicio->id == $qr->id_servicio)
                            <option value="{{ $servicio->id }}" selected>{{ $servicio->servicio }}</option>
                        @else
                            <option value="{{ $servicio->id }}">{{ $servicio->servicio }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
    </div>

        @method("PATCH")
    @else

    <form action="{{ route('qr.subirDocumento') }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre:</span>
            <input type="text" name="nombre">

            <span>Subir documento:</span>
            <input type="file" name="documento[]">

                Servicio: <select name="id_servicio">
                @if (isset($serviciosList))
                    @foreach ($serviciosList as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->servicio }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        @endisset
        @csrf
        <input type="submit" value="Enviar">
    </form>    
@endsection
