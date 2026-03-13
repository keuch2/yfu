@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="alert alert-success"><span style="font-size:1.5em">✅</span><div><strong>Sistema YFU Completo Integrado</strong><br>Todos los módulos operativos | Pipeline + Gestión + Export</div></div>

<h3 style="color:var(--p);margin:20px 0 15px">📊 Métricas Generales</h3>

<div class="stats-grid">
<a class="stat-card" href="{{ route('pipeline.index', ['inbound', 'prospect']) }}"><div class="stat-icon">👋</div><div class="stat-value">{{ $stats['ib_prospect'] }}</div><div class="stat-title">Interesados IB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['inbound', 'applicant']) }}"><div class="stat-icon">📝</div><div class="stat-value">{{ $stats['ib_applicant'] }}</div><div class="stat-title">Postulantes IB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['inbound', 'participant']) }}"><div class="stat-icon">✈️</div><div class="stat-value">{{ $stats['ib_participant'] }}</div><div class="stat-title">Participantes IB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['inbound', 'alumni']) }}"><div class="stat-icon">🎓</div><div class="stat-value">{{ $stats['ib_alumni'] }}</div><div class="stat-title">Alumni IB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['outbound', 'prospect']) }}"><div class="stat-icon">👋</div><div class="stat-value">{{ $stats['ob_prospect'] }}</div><div class="stat-title">Interesados OB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['outbound', 'applicant']) }}"><div class="stat-icon">📝</div><div class="stat-value">{{ $stats['ob_applicant'] }}</div><div class="stat-title">Postulantes OB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['outbound', 'participant']) }}"><div class="stat-icon">✈️</div><div class="stat-value">{{ $stats['ob_participant'] }}</div><div class="stat-title">Participantes OB</div></a>
<a class="stat-card" href="{{ route('pipeline.index', ['outbound', 'alumni']) }}"><div class="stat-icon">🎓</div><div class="stat-value">{{ $stats['ob_alumni'] }}</div><div class="stat-title">Alumni OB</div></a>
<a class="stat-card" href="{{ route('families.index') }}"><div class="stat-icon">🏠</div><div class="stat-value">{{ $stats['families'] }}</div><div class="stat-title">Familias</div></a>
<a class="stat-card" href="{{ route('coordinators.index') }}"><div class="stat-icon">👨‍💼</div><div class="stat-value">{{ $stats['coordinators'] }}</div><div class="stat-title">Coordinadores</div></a>
</div>

<div class="card"><h3 style="color:var(--p);margin-bottom:15px">🚀 Acciones Rápidas</h3>
<a class="btn" href="{{ route('pipeline.index', ['inbound', 'prospect']) }}">➕ Nuevo Interesado IB</a>
<a class="btn" href="{{ route('pipeline.index', ['outbound', 'prospect']) }}">➕ Nuevo Interesado OB</a>
<a class="btn" href="{{ route('families.index') }}">🏠 Familias</a>
<a class="btn" href="{{ route('coordinators.index') }}">👨‍💼 Coordinadores</a>
@if(auth()->user()->isAdmin())
<a class="btn btn-success" href="{{ route('export.json') }}">📥 Exportar JSON</a>
<a class="btn btn-info" href="{{ route('export.excel') }}">📊 Exportar Excel</a>
@endif
</div>

<div class="card"><h3 style="color:var(--p);margin-bottom:12px">📋 Módulos Integrados</h3>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:12px">
<div style="padding:12px;background:#f8f9fa;border-radius:8px;border-left:3px solid var(--p)"><strong>Pipeline Completo</strong><br><small>8 etapas con conversiones</small></div>
<div style="padding:12px;background:#f8f9fa;border-radius:8px;border-left:3px solid var(--s)"><strong>Familias & Coordinadores</strong><br><small>Gestión completa</small></div>
<div style="padding:12px;background:#f8f9fa;border-radius:8px;border-left:3px solid var(--i)"><strong>Exportación</strong><br><small>JSON + Excel</small></div>
<div style="padding:12px;background:#f8f9fa;border-radius:8px;border-left:3px solid var(--w)"><strong>Roles & Permisos</strong><br><small>Super Admin, Admin, Agente</small></div>
</div>
</div>
@endsection
