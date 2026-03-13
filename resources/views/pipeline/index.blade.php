@extends('layouts.app')
@section('title', ($type === 'inbound' ? '🔵' : '🟢') . ' ' . $stageLabel . ' ' . $typeLabel)

@section('content')
<button class="btn" onclick="openModal('create-modal')">➕ Nuevo {{ $stageLabel }}</button>

@if($persons->isEmpty())
<div class="empty-state"><div class="empty-icon">📭</div><h3>No hay registros</h3><p>Haz click en "Nuevo" para agregar</p></div>
@else
<table>
<thead><tr>
<th>Nombre</th>
<th>Email</th>
<th>País</th>
@if($stage !== 'prospect')
<th>{{ $type === 'inbound' ? 'Programa' : 'Destino' }}</th>
@endif
@if(in_array($stage, ['participant', 'alumni']))
<th>Fecha Inicio</th>
<th>Fecha Fin</th>
@endif
<th>Acciones</th>
</tr></thead>
<tbody>
@foreach($persons as $person)
<tr>
<td><strong>{{ $person->name }}</strong></td>
<td>{{ $person->email }}</td>
<td>{{ $person->country }}</td>
@if($stage !== 'prospect')
<td>{{ $type === 'inbound' ? $person->program : $person->destination }}</td>
@endif
@if(in_array($stage, ['participant', 'alumni']))
<td>{{ $person->start_date?->format('d/m/Y') ?? '-' }}</td>
<td>{{ $person->end_date?->format('d/m/Y') ?? '-' }}</td>
@endif
<td>
<button class="btn btn-sm btn-warning" onclick="openModal('edit-modal-{{ $person->id }}')">✏️</button>
@if(auth()->user()->isAdmin())
@php $nextStage = \App\Models\PipelinePerson::nextStage($stage); @endphp
@if($nextStage)
<form method="POST" action="{{ route('pipeline.convert', [$type, $stage, $person]) }}" style="display:inline" onsubmit="return confirm('¿Convertir a {{ \App\Models\PipelinePerson::stageLabel($nextStage) }}?')">
@csrf
<button type="submit" class="btn btn-sm btn-success">→ {{ Str::limit(\App\Models\PipelinePerson::stageLabel($nextStage), 4) }}</button>
</form>
@endif
<form method="POST" action="{{ route('pipeline.destroy', [$type, $stage, $person]) }}" style="display:inline" onsubmit="return confirm('¿Eliminar este registro?')">
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
<h2 class="modal-title">➕ Nuevo {{ $stageLabel }}</h2>
<button class="close-btn" onclick="closeModal('create-modal')">×</button>
</div>
<form method="POST" action="{{ route('pipeline.store', [$type, $stage]) }}">
@csrf
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ old('name') }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ old('email') }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ old('phone') }}"></div>
<div class="form-group"><label>País *</label>
<select name="country" required>
<option value="">Seleccionar...</option>
@foreach($countries as $c)
<option value="{{ $c }}" {{ old('country') === $c ? 'selected' : '' }}>{{ $c }}</option>
@endforeach
</select>
</div>
</div>
@if($stage !== 'prospect')
@if($type === 'inbound')
<div class="form-group"><label>Programa *</label>
<select name="program" required>
<option value="">Seleccionar...</option>
@foreach($programs as $p)
<option value="{{ $p['name'] }}" {{ old('program') === $p['name'] ? 'selected' : '' }}>{{ $p['name'] }} - ${{ number_format($p['price']) }}</option>
@endforeach
</select>
</div>
@else
<div class="form-group"><label>Destino *</label>
<select name="destination" required>
<option value="">Seleccionar...</option>
@foreach($destinations as $d)
<option value="{{ $d }}" {{ old('destination') === $d ? 'selected' : '' }}>{{ $d }}</option>
@endforeach
</select>
</div>
@endif
@endif
@if(in_array($stage, ['participant', 'alumni']))
<div class="form-row">
<div class="form-group"><label>Fecha Inicio</label><input type="date" name="start_date" value="{{ old('start_date') }}"></div>
<div class="form-group"><label>Fecha Fin</label><input type="date" name="end_date" value="{{ old('end_date') }}"></div>
</div>
@endif
<div class="form-group"><label>Notas</label><textarea name="notes" rows="3">{{ old('notes') }}</textarea></div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('create-modal')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>

{{-- EDIT MODALS --}}
@foreach($persons as $person)
<div id="edit-modal-{{ $person->id }}" class="modal-overlay">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title">✏️ Editar {{ $stageLabel }}</h2>
<button class="close-btn" onclick="closeModal('edit-modal-{{ $person->id }}')">×</button>
</div>
<form method="POST" action="{{ route('pipeline.update', [$type, $stage, $person]) }}">
@csrf @method('PUT')
<div class="form-row">
<div class="form-group"><label>Nombre *</label><input name="name" required value="{{ $person->name }}"></div>
<div class="form-group"><label>Email *</label><input type="email" name="email" required value="{{ $person->email }}"></div>
</div>
<div class="form-row">
<div class="form-group"><label>Teléfono</label><input name="phone" placeholder="+595 981..." value="{{ $person->phone }}"></div>
<div class="form-group"><label>País *</label>
<select name="country" required>
<option value="">Seleccionar...</option>
@foreach($countries as $c)
<option value="{{ $c }}" {{ $person->country === $c ? 'selected' : '' }}>{{ $c }}</option>
@endforeach
</select>
</div>
</div>
@if($stage !== 'prospect')
@if($type === 'inbound')
<div class="form-group"><label>Programa *</label>
<select name="program" required>
<option value="">Seleccionar...</option>
@foreach($programs as $p)
<option value="{{ $p['name'] }}" {{ $person->program === $p['name'] ? 'selected' : '' }}>{{ $p['name'] }} - ${{ number_format($p['price']) }}</option>
@endforeach
</select>
</div>
@else
<div class="form-group"><label>Destino *</label>
<select name="destination" required>
<option value="">Seleccionar...</option>
@foreach($destinations as $d)
<option value="{{ $d }}" {{ $person->destination === $d ? 'selected' : '' }}>{{ $d }}</option>
@endforeach
</select>
</div>
@endif
@endif
@if(in_array($stage, ['participant', 'alumni']))
<div class="form-row">
<div class="form-group"><label>Fecha Inicio</label><input type="date" name="start_date" value="{{ $person->start_date?->format('Y-m-d') }}"></div>
<div class="form-group"><label>Fecha Fin</label><input type="date" name="end_date" value="{{ $person->end_date?->format('Y-m-d') }}"></div>
</div>
@endif
<div class="form-group"><label>Notas</label><textarea name="notes" rows="3">{{ $person->notes }}</textarea></div>
<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
<button type="button" class="btn btn-secondary" onclick="closeModal('edit-modal-{{ $person->id }}')">Cancelar</button>
<button type="submit" class="btn btn-success">💾 Guardar</button>
</div>
</form>
</div>
</div>
@endforeach
@endsection
