@extends("layouts/master")
@section('title', 'Panel Principal')
@section('content')

    @isset($qr)
        <form action="{{ route('qr.update', ['id' => $qr->id]) }}" method="POST">
            <div style="height: 100px; margin-right: 5px;">
                <span>Nombre:</span>
                <input type="text" name="nombre" value="{{ $qr->nombre }}">

                <span>Enlace (Opcional):</span>
                <input type="text" name="enlace" value="{{ $qr->enlace }}">

                <span>Documento (Opcional):</span>
                <input type="file" name="documento" value="{{ $qr->documento }}">

            </div>
            @method("PATCH")

        @else

            <form action="{{ route('qr.store') }}" method="POST">
                <div class="col-12 col-xxl-6 d-flex align-items-center" style="height: 100px; margin-right: 5px;">

                    <span>Nombre:</span>
                    <input type="text" name="nombre">

                    <span>Enlace (Opcional):</span>
                    <input type="text" name="enlace">

                    <span>Documento (Opcional):</span>
                    <input type="file" name="documento">

                </div>

            @endisset
            @csrf

            <input type="submit" class="btn btn-outline-secondary">
        </form>
    @endsection
