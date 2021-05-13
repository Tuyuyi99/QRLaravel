@extends("layouts/form")
@section('title', 'Editar o Nuevo Documento')
@section('content')

@isset($documento)
    <form action="{{ route('documento.update', ['id' => $documento->id]) }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre del documento:</span>
            <input type="text" name="nombre" value="{{ $documento->nombre }}">


            <span>Subir documento (Sólo PDFs):</span>
            <input type="file" name="documento" value="{{ $documento->documento }}">
        </div>
        @method("PATCH")
    @else

    <form action="{{ route('documento.store') }}" method="POST" enctype="multipart/form-data">
        <div style="height: 100px; margin-right: 5px;">

            <span>Nombre del documento:</span>
            <input type="text" name="nombre">

            <span>Subir documento (Sólo PDFs):</span>
            <input type="file" name="documento">   
                           
        </div>
        @endisset
        @csrf
        <input type="submit" value="Subir PDF">
    </form>    
@endsection