@extends('layouts.app')
@section('title', '📤 Export')

@section('content')
<div class="card">
<h3 style="color:var(--p);margin-bottom:15px">📤 Exportación de Datos</h3>
<p style="margin-bottom:20px;color:#666">Exportá todos los datos del sistema en el formato que prefieras.</p>
<a class="btn btn-success" href="{{ route('export.json') }}">📥 Exportar Todo (JSON)</a>
<a class="btn btn-info" href="{{ route('export.excel') }}">📊 Exportar Excel</a>
</div>
@endsection
