@extends('layouts.app')
@section('title', '👨‍💼 Coordinadores')

@section('content')
@if(auth()->user()->isAdmin())
<button class="btn" onclick="openModal('create-modal')">➕ Nuevo Coordinador</button>
@endif

@if($coordinators->isEmpty())
<div class="empty-state"><div class="empty-icon">👨‍💼</div><h3>No hay coordinadores</h3><p>Haz click en "Nuevo" para agregar</p></div>
@else
<table>
<thead><tr>
<th>Nombre</th>
<th>Email</th>
<th>Teléfono</th>
<th>Región</th>
@if(auth()->user()->isAdmin())
<th>Acciones</th>
@endif
</tr></thead>
<tbody>
@foreach($coordinators as $coord)
<tr>
<td><strong>{{ $coord->name }}</strong></td>
<td>{{ $coord->email }}</td>
<td>{{ $coord->phone ?? '-' }}</td>
<td>{{ $coord->region ?? '-' }}</td>
@if(auth()->user()->isAdmin())
<td>
<button class="btn btn-sm btn-warning" onclick="openModal('edit-modal-{{ $coord->id }}')">✏️</button>
<form method="POST" action="{{ route('coordinators.destroy', $coord) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este coordinador?')">
@csrf @method('DELETE')
<button type="submit" class="btn btn-sm btn-danger">🗑️</button>
</form>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
@endif
@endsection

@section('modals')
@if(auth()->user()->isAdmin())
{{-- CREATE MODAL --}}
<div id="create-modal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">➕ Nuevo Coordinador</h2>
<button class="close-btn" onclick="closeModal('create-modal')">×</button>
</div>
<form method="POST" action="{{ route('coordinators.store') }}">
@csrf
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ old('name') }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ old('email') }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ old('phone') }}"></div>
<div class="form-group"><label>Región</label><input name="region" value="{{ old('region') }}"></div>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('create-modal')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>

{{-- EDIT MODALS --}}
@foreach($coordinators as $coord)
<div id="edit-modal-{{ $coord->id }}" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">✏️ Editar Coordinador</h2>
<button class="close-btn" onclick="closeModal('edit-modal-{{ $coord->id }}')">×</button>
</div>
<form method="POST" action="{{ route('coordinators.update', $coord) }}">
@csrf @method('PUT')
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ $coord->name }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ $coord->email }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ $coord->phone }}"></div>
<div class="form-group"><label>Región</label><input name="region" value="{{ $coord->region }}"></div>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('edit-modal-{{ $coord->id }}')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>
@endforeach
@endif
@endsection
