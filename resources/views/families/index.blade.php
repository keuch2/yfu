@extends('layouts.app')
@section('title', '🏠 Familias')

@section('content')
@if(auth()->user()->isAdmin())
<button class="btn" onclick="openModal('create-modal')">➕ Nueva Familia</button>
@endif

@if($families->isEmpty())
<div class="empty-state"><div class="empty-icon">🏠</div><h3>No hay familias</h3><p>Haz click en "Nueva" para agregar</p></div>
@else
<table>
<thead><tr>
<th>Familia</th>
<th>Ciudad</th>
<th>Contacto</th>
<th>Email</th>
<th>Capacidad</th>
<th>Estado</th>
@if(auth()->user()->isAdmin())
<th>Acciones</th>
@endif
</tr></thead>
<tbody>
@foreach($families as $family)
<tr>
<td><strong>{{ $family->name }}</strong></td>
<td>{{ $family->city }}</td>
<td>{{ $family->contact }}</td>
<td>{{ $family->email }}</td>
<td>{{ $family->capacity }}</td>
<td><span class="badge badge-{{ $family->status === 'Disponible' ? 'success' : 'warning' }}">{{ $family->status }}</span></td>
@if(auth()->user()->isAdmin())
<td>
<button class="btn btn-sm btn-warning" onclick="openModal('edit-modal-{{ $family->id }}')">✏️</button>
<form method="POST" action="{{ route('families.destroy', $family) }}" style="display:inline" onsubmit="return confirm('¿Eliminar esta familia?')">
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
<h2 class="modal-title">➕ Nueva Familia</h2>
<button class="close-btn" onclick="closeModal('create-modal')">×</button>
</div>
<form method="POST" action="{{ route('families.store') }}">
@csrf
<div class="form-row">
<div class="form-group"><label>Apellido Familia *</label><input name="name" required value="{{ old('name') }}"></div>
<div class="form-group"><label>Ciudad *</label>
<select name="city" required>
<option value="">Seleccionar...</option>
@foreach($cities as $c)
<option value="{{ $c }}" {{ old('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
@endforeach
</select>
</div>
</div>
<div class="form-row">
<div class="form-group"><label>Contacto *</label><input name="contact" required value="{{ old('contact') }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ old('email') }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ old('phone') }}"></div>
<div class="form-group"><label>Capacidad</label><input type="number" name="capacity" value="{{ old('capacity', 1) }}" min="1" max="5"></div>
</div>
<div class="form-group"><label>Estado</label>
<select name="status">
<option value="Disponible" {{ old('status') === 'Disponible' ? 'selected' : '' }}>Disponible</option>
<option value="Ocupada" {{ old('status') === 'Ocupada' ? 'selected' : '' }}>Ocupada</option>
</select>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('create-modal')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>

{{-- EDIT MODALS --}}
@foreach($families as $family)
<div id="edit-modal-{{ $family->id }}" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">✏️ Editar Familia</h2>
<button class="close-btn" onclick="closeModal('edit-modal-{{ $family->id }}')">×</button>
</div>
<form method="POST" action="{{ route('families.update', $family) }}">
@csrf @method('PUT')
<div class="form-row">
<div class="form-group"><label>Apellido Familia *</label><input name="name" required value="{{ $family->name }}"></div>
<div class="form-group"><label>Ciudad *</label>
<select name="city" required>
<option value="">Seleccionar...</option>
@foreach($cities as $c)
<option value="{{ $c }}" {{ $family->city === $c ? 'selected' : '' }}>{{ $c }}</option>
@endforeach
</select>
</div>
</div>
<div class="form-row">
<div class="form-group"><label>Contacto *</label><input name="contact" required value="{{ $family->contact }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ $family->email }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ $family->phone }}"></div>
<div class="form-group"><label>Capacidad</label><input type="number" name="capacity" value="{{ $family->capacity }}" min="1" max="5"></div>
</div>
<div class="form-group"><label>Estado</label>
<select name="status">
<option value="Disponible" {{ $family->status === 'Disponible' ? 'selected' : '' }}>Disponible</option>
<option value="Ocupada" {{ $family->status === 'Ocupada' ? 'selected' : '' }}>Ocupada</option>
</select>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('edit-modal-{{ $family->id }}')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>
@endforeach
@endif
@endsection
