<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>YFU Paraguay - Sistema Integrado</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--p:#6b4c9a;--pd:#543a7a;--s:#28a745;--w:#ffc107;--d:#dc3545;--i:#17a2b8}
body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,var(--p),var(--pd));min-height:100vh}
.sidebar{position:fixed;left:0;top:0;width:260px;height:100vh;background:linear-gradient(180deg,var(--p),var(--pd));color:#fff;z-index:1000;overflow-y:auto;box-shadow:5px 0 25px rgba(0,0,0,0.3)}
.sidebar-header{padding:20px 15px;border-bottom:1px solid rgba(255,255,255,0.2);text-align:center;background:rgba(0,0,0,0.15)}
.logo{width:80px;height:80px;margin:0 auto 10px;background:#fff;border-radius:50%;padding:10px;display:flex;align-items:center;justify-content:center;font-size:2em;font-weight:bold;color:var(--p)}
.sidebar-header h1{font-size:1.4em;margin-bottom:3px}
.menu-section{margin:8px 0;padding:0 8px}
.menu-section-title{padding:8px 10px;font-size:0.65em;text-transform:uppercase;letter-spacing:1.2px;opacity:0.7;font-weight:bold}
.menu-item{padding:9px 12px;cursor:pointer;transition:all 0.3s;display:flex;align-items:center;gap:8px;color:#fff;border-radius:7px;margin:2px 0;font-size:0.85em;text-decoration:none}
.menu-item:hover{background:rgba(255,255,255,0.15);padding-left:16px;color:#fff}
.menu-item.active{background:rgba(255,255,255,0.25);border-left:3px solid #fff;font-weight:600}
.main{margin-left:260px;min-height:100vh;background:#f5f7fa}
.topbar{background:#fff;padding:15px 30px;box-shadow:0 2px 12px rgba(0,0,0,0.1);display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:999}
.topbar h2{color:var(--p);font-size:1.6em;font-weight:700}
.topbar-right{display:flex;align-items:center;gap:15px;font-size:0.9em;color:#666}
.content{padding:25px}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:18px;margin-bottom:20px}
.stat-card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 3px 15px rgba(107,76,154,0.12);transition:all 0.3s;cursor:pointer;position:relative;overflow:hidden;text-decoration:none;color:inherit;display:block}
.stat-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:3px;background:linear-gradient(90deg,var(--p),#ff6b9d)}
.stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 25px rgba(107,76,154,0.2)}
.stat-icon{font-size:2.5em;margin-bottom:8px}
.stat-value{font-size:2.2em;font-weight:700;color:var(--p);margin-bottom:6px}
.stat-title{font-size:0.82em;color:#666;text-transform:uppercase;letter-spacing:0.4px;font-weight:600}
.btn{background:var(--p);color:#fff;padding:10px 20px;border:none;border-radius:7px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.3s;display:inline-flex;align-items:center;gap:7px;margin:3px;text-decoration:none}
.btn:hover{background:var(--pd);transform:translateY(-2px);box-shadow:0 5px 15px rgba(107,76,154,0.3);color:#fff}
.btn-sm{padding:6px 12px;font-size:11px}
.btn-success{background:var(--s)}.btn-success:hover{background:#218838}
.btn-danger{background:var(--d)}.btn-danger:hover{background:#c82333}
.btn-info{background:var(--i)}.btn-info:hover{background:#138496}
.btn-warning{background:var(--w);color:#333}.btn-warning:hover{background:#e0a800}
.btn-secondary{background:#6c757d}.btn-secondary:hover{background:#5a6268}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-top:15px}
th{background:linear-gradient(135deg,var(--p),var(--pd));color:#fff;padding:12px 10px;text-align:left;font-weight:600;font-size:0.82em}
td{padding:12px 10px;border-bottom:1px solid #f0f0f0;font-size:0.82em}
tr:hover{background:#f8f9fa}
.badge{padding:5px 11px;border-radius:14px;font-size:0.72em;font-weight:600;display:inline-block}
.badge-success{background:#d4edda;color:#155724}
.badge-warning{background:#fff3cd;color:#856404}
.badge-danger{background:#f8d7da;color:#721c24}
.badge-info{background:#d1ecf1;color:#0c5460}
.badge-primary{background:#e6d9f5;color:var(--pd)}
.modal-overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:2000;padding:12px;overflow-y:auto}
.modal-overlay.active{display:block}
.modal-content{background:#fff;padding:28px;border-radius:10px;max-width:850px;margin:22px auto;max-height:86vh;overflow-y:auto;box-shadow:0 18px 55px rgba(0,0,0,0.3)}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #e0e0e0}
.modal-title{color:var(--p);font-size:1.7em;font-weight:700}
.close-btn{background:none;border:none;font-size:2em;cursor:pointer;color:#999;line-height:1}
.close-btn:hover{color:#333}
.form-group{margin-bottom:16px}
.form-group label{display:block;margin-bottom:5px;font-weight:600;color:#333;font-size:0.88em}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px;border:2px solid #e0e0e0;border-radius:7px;font-size:13px}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:var(--p);box-shadow:0 0 0 3px rgba(107,76,154,0.1)}
.form-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px}
.alert{padding:14px;border-radius:8px;margin:14px 0;display:flex;align-items:flex-start;gap:10px}
.alert-info{background:#d1ecf1;color:#0c5460;border-left:3px solid var(--i)}
.alert-success{background:#d4edda;color:#155724;border-left:3px solid var(--s)}
.alert-warning{background:#fff3cd;color:#856404;border-left:3px solid var(--w)}
.alert-danger{background:#f8d7da;color:#721c24;border-left:3px solid var(--d)}
.empty-state{text-align:center;padding:50px 20px;color:#999}
.empty-icon{font-size:3.5em;margin-bottom:18px;opacity:0.5}
.card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 15px rgba(0,0,0,0.08);margin-bottom:16px}
.card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}
@keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.fade-in{animation:fadeIn 0.3s}
</style>
</head>
<body>

<div class="sidebar">
<div class="sidebar-header">
<div class="logo">YFU</div>
<h1>YFU Paraguay</h1>
<p style="font-size:0.85em;opacity:0.9">Sistema Integrado</p>
</div>

<div class="menu-section"><div class="menu-section-title">PRINCIPAL</div>
<a class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">📊 Dashboard</a>
</div>

<div class="menu-section"><div class="menu-section-title">PIPELINE</div>
<a class="menu-item {{ request()->is('pipeline/inbound/prospect') ? 'active' : '' }}" href="{{ route('pipeline.index', ['inbound', 'prospect']) }}">👋 Interesados IB</a>
<a class="menu-item {{ request()->is('pipeline/inbound/applicant') ? 'active' : '' }}" href="{{ route('pipeline.index', ['inbound', 'applicant']) }}">📝 Postulantes IB</a>
<a class="menu-item {{ request()->is('pipeline/inbound/participant') ? 'active' : '' }}" href="{{ route('pipeline.index', ['inbound', 'participant']) }}">✈️ Participantes IB</a>
<a class="menu-item {{ request()->is('pipeline/inbound/alumni') ? 'active' : '' }}" href="{{ route('pipeline.index', ['inbound', 'alumni']) }}">🎓 Alumni IB</a>
<a class="menu-item {{ request()->is('pipeline/outbound/prospect') ? 'active' : '' }}" href="{{ route('pipeline.index', ['outbound', 'prospect']) }}">👋 Interesados OB</a>
<a class="menu-item {{ request()->is('pipeline/outbound/applicant') ? 'active' : '' }}" href="{{ route('pipeline.index', ['outbound', 'applicant']) }}">📝 Postulantes OB</a>
<a class="menu-item {{ request()->is('pipeline/outbound/participant') ? 'active' : '' }}" href="{{ route('pipeline.index', ['outbound', 'participant']) }}">✈️ Participantes OB</a>
<a class="menu-item {{ request()->is('pipeline/outbound/alumni') ? 'active' : '' }}" href="{{ route('pipeline.index', ['outbound', 'alumni']) }}">🎓 Alumni OB</a>
</div>

<div class="menu-section"><div class="menu-section-title">GESTIÓN</div>
<a class="menu-item {{ request()->routeIs('families.*') ? 'active' : '' }}" href="{{ route('families.index') }}">🏠 Familias</a>
<a class="menu-item {{ request()->routeIs('coordinators.*') ? 'active' : '' }}" href="{{ route('coordinators.index') }}">👨‍💼 Coordinadores</a>
</div>

@if(auth()->user()->isAdmin())
<div class="menu-section"><div class="menu-section-title">SISTEMA</div>
<a class="menu-item {{ request()->routeIs('export.*') ? 'active' : '' }}" href="{{ route('export.index') }}">📤 Export</a>
@if(auth()->user()->isSuperAdmin())
<a class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">👤 Usuarios</a>
@endif
</div>
@endif

<div class="menu-section" style="margin-top:20px;padding-bottom:20px">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="menu-item" style="width:100%;border:none;background:rgba(255,255,255,0.1);cursor:pointer;font-family:inherit">🚪 Cerrar Sesión</button>
</form>
</div>
</div>

<div class="main">
<div class="topbar">
<h2>@yield('title', 'Dashboard')</h2>
<div class="topbar-right">
<span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
<span>|</span>
<span>{{ auth()->user()->name }} <span class="badge badge-primary">{{ auth()->user()->role_label }}</span></span>
</div>
</div>

<div class="content fade-in">
@if(session('success'))
<div class="alert alert-success"><span style="font-size:1.3em">✅</span><div>{{ session('success') }}</div></div>
@endif
@if(session('error'))
<div class="alert alert-danger"><span style="font-size:1.3em">❌</span><div>{{ session('error') }}</div></div>
@endif
@if($errors->any())
<div class="alert alert-danger"><span style="font-size:1.3em">⚠️</span><div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div></div>
@endif

@yield('content')
</div>
</div>

@yield('modals')

<script>
function openModal(id){document.getElementById(id).classList.add('active')}
function closeModal(id){document.getElementById(id).classList.remove('active')}
document.querySelectorAll('.modal-overlay').forEach(m=>{m.addEventListener('click',e=>{if(e.target===m)m.classList.remove('active')})});
</script>
@yield('scripts')
</body>
</html>
