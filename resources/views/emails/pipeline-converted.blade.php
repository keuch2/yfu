<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
body{font-family:'Segoe UI',sans-serif;background:#f5f7fa;margin:0;padding:20px}
.container{max-width:600px;margin:0 auto;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 15px rgba(0,0,0,0.1)}
.header{background:linear-gradient(135deg,#6b4c9a,#543a7a);color:#fff;padding:25px;text-align:center}
.header h1{margin:0;font-size:1.4em}
.body{padding:25px}
.badge{display:inline-block;padding:6px 14px;border-radius:14px;font-size:0.85em;font-weight:600}
.badge-from{background:#fff3cd;color:#856404}
.badge-to{background:#d4edda;color:#155724}
.arrow{font-size:1.5em;margin:0 10px}
.info{margin:20px 0;padding:15px;background:#f8f9fa;border-radius:8px;border-left:3px solid #6b4c9a}
.footer{padding:15px 25px;background:#f8f9fa;text-align:center;font-size:0.8em;color:#999}
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1>YFU Paraguay - Conversión de Pipeline</h1>
</div>
<div class="body">
<p>Se ha realizado una conversión en el pipeline:</p>
<div style="text-align:center;margin:20px 0">
<span class="badge badge-from">{{ \App\Models\PipelinePerson::stageLabel($fromStage) }}</span>
<span class="arrow">→</span>
<span class="badge badge-to">{{ \App\Models\PipelinePerson::stageLabel($toStage) }}</span>
</div>
<div class="info">
<strong>{{ $person->name }}</strong><br>
Email: {{ $person->email }}<br>
País: {{ $person->country }}<br>
Tipo: {{ $person->type === 'inbound' ? 'Inbound' : 'Outbound' }}<br>
@if($person->program)Programa: {{ $person->program }}<br>@endif
@if($person->destination)Destino: {{ $person->destination }}<br>@endif
</div>
<p style="color:#666;font-size:0.9em">Fecha: {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY, HH:mm') }}</p>
</div>
<div class="footer">
YFU Paraguay - Sistema Integrado
</div>
</div>
</body>
</html>
