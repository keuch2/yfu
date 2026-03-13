@extends('layouts.app')
@section('title', '👤 Usuarios')

@section('content')
<button class="btn" onclick="openModal('create-modal')">➕ Nuevo Usuario</button>

@if($users->isEmpty())
<div class="empty-state"><div class="empty-icon">👤</div><h3>No hay usuarios</h3></div>
@else
<table>
<thead><tr>
<th>Nombre</th>
<th>Email</th>
<th>Rol</th>
<th>Estado</th>
<th>Creado</th>
<th>Acciones</th>
</tr></thead>
<tbody>
@foreach($users as $user)
<tr>
<td><strong>{{ $user->name }}</strong></td>
<td>{{ $user->email }}</td>
<td><span class="badge badge-primary">{{ $user->role_label }}</span></td>
<td><span class="badge badge-{{ $user->active ? 'success' : 'danger' }}">{{ $user->active ? 'Activo' : 'Inactivo' }}</span></td>
<td>{{ $user->created_at->format('d/m/Y') }}</td>
<td>
<button class="btn btn-sm btn-warning" onclick="openModal('edit-modal-{{ $user->id }}')">✏️</button>
@if($user->id !== auth()->id())
<form method="POST" action="{{ route('users.destroy', $user) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este usuario?')">
@csrf @method('DELETE')
<button type="submit" class="btn btn-sm btn-danger">🗑️</button>
</form>
@endif
</td>
</tr>
@endforeach
</tbody>
</table>
@endif
@endsection

@section('modals')
{{-- CREATE MODAL --}}
<div id="create-modal" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">➕ Nuevo Usuario</h2>
<button class="close-btn" onclick="closeModal('create-modal')">×</button>
</div>
<form method="POST" action="{{ route('users.store') }}">
@csrf
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ old('name') }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ old('email') }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Contraseña *</label><input type="password" name="password" required minlength="6"></div>
<div class="form-group"><label>Rol *</label>
<select name="role" required>
<option value="agent">Agente</option>
<option value="admin">Administrador</option>
<option value="super_admin">Super Administrador</option>
</select>
</div>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('create-modal')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>

{{-- EDIT MODALS --}}
@foreach($users as $user)
<div id="edit-modal-{{ $user->id }}" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">✏️ Editar Usuario</h2>
<button class="close-btn" onclick="closeModal('edit-modal-{{ $user->id }}')">×</button>
</div>
<form method="POST" action="{{ route('users.update', $user) }}">
@csrf @method('PUT')
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ $user->name }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ $user->email }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Nueva Contraseña <small>(dejar vacío para no cambiar)</small></label><input type="password" name="password" minlength="6"></div>
<div class="form-group"><label>Rol *</label>
<select name="role" required>
<option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agente</option>
<option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
<option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Administrador</option>
</select>
</div>
</div>
<div class="form-group"><label>Estado</label>
<select name="active">
<option value="1" {{ $user->active ? 'selected' : '' }}>Activo</option>
<option value="0" {{ !$user->active ? 'selected' : '' }}>Inactivo</option>
</select>
</div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('edit-modal-{{ $user->id }}')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>
@endforeach
@endsection
