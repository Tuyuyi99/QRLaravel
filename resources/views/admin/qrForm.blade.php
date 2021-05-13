@extends("layouts/form")
@section('title', 'Editar o Nuevo QR')
@section('content')

@isset($qr)
    <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre:</span>
            <input type="text" name="nombre" value="{{ $qr->nombre }}">

            <span>Enlace</span>
            <input type="text" name="enlace" value="{{ $qr->enlace }}">

            <select id="select">
                <option value="">Selecciona qué vas a subir</option>
                <option value="Documento" id="Documento">Documento</option>
                <option value="Enlace" id="Enlace">Enlace</option>
            </select>

            <div class="documento oculto">

                <span>Documento:</span>
                <select name="id_documento">

                    @if (isset($documentosList))
                    @foreach ($documentosList as $documento)
                        <option value="{{ $documento->id }}">
                            {{ $documento->nombre }}</option>
                    @endforeach
                @endif

                </select>
            </div>

            <div class="enlace oculto">

                <span>Enlace</span>
                <input type="text" name="enlace" class="enlace">
            </div>                 
    </div>


        <select name="id_servicio">
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

    <form action="{{ route('qr.store') }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre:</span>
            <input type="text" name="nombre">

            <select id="select">
                <option value="">Selecciona qué vas a subir</option>
                <option value="Documento" id="Documento">Documento</option>
                <option value="Enlace" id="Enlace">Enlace</option>
            </select>

            <input id="rutaDocumento" type="hidden" value="C:\Users\CuestaPablo85W\Desktop\laravel-qr-code\public\assets\PDFs\pruebdenifitav.pdf">

            <div class="documento oculto">

                <span>Documento:</span>
                <select name="id_documento">

                    @if (isset($documentosList))
                    @foreach ($documentosList as $documento)
                        <option value="{{ $documento->id }}">
                            {{ $documento->nombre }}</option>
                    @endforeach
                @endif
                </select>
            </div>

            <div class="enlace oculto">

                <span>Enlace</span>
                <input type="text" name="enlace" class="enlace" id="enlace" value="">
            </div>                 

            <select name="id_servicio">
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
        <input type="submit" value="Crear" onclick="rellenarInput()">
    </form>    
@endsection
