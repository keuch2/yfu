<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YFU Paraguay - Iniciar Sesión</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--p:#6b4c9a;--pd:#543a7a}
body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,var(--p),var(--pd));min-height:100vh;display:flex;align-items:center;justify-content:center}
.login-box{background:#fff;padding:40px;border-radius:15px;box-shadow:0 20px 60px rgba(0,0,0,0.3);width:100%;max-width:420px}
.login-header{text-align:center;margin-bottom:30px}
.logo{width:90px;height:90px;margin:0 auto 15px;background:linear-gradient(135deg,var(--p),var(--pd));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.2em;font-weight:bold;color:#fff}
.login-header h1{color:var(--p);font-size:1.6em;margin-bottom:5px}
.login-header p{color:#666;font-size:0.9em}
.form-group{margin-bottom:18px}
.form-group label{display:block;margin-bottom:6px;font-weight:600;color:#333;font-size:0.88em}
.form-group input{width:100%;padding:12px;border:2px solid #e0e0e0;border-radius:8px;font-size:14px;transition:border-color 0.3s}
.form-group input:focus{outline:none;border-color:var(--p);box-shadow:0 0 0 3px rgba(107,76,154,0.1)}
.remember{display:flex;align-items:center;gap:8px;margin-bottom:20px;font-size:0.88em;color:#555}
.remember input{width:auto}
.btn{background:linear-gradient(135deg,var(--p),var(--pd));color:#fff;padding:14px;border:none;border-radius:8px;cursor:pointer;font-size:15px;font-weight:600;width:100%;transition:all 0.3s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(107,76,154,0.4)}
.alert{padding:12px;border-radius:8px;margin-bottom:18px;background:#f8d7da;color:#721c24;border-left:3px solid #dc3545;font-size:0.88em}
.demo-info{margin-top:25px;padding:15px;background:#f8f9fa;border-radius:8px;font-size:0.8em;color:#666;text-align:center;border:1px dashed #ddd}
.demo-info strong{color:var(--p)}
</style>
</head>
<body>
<div class="login-box">
<div class="login-header">
<div class="logo">YFU</div>
<h1>YFU Paraguay</h1>
<p>Sistema Integrado</p>
</div>

@if($errors->any())
<div class="alert">
@foreach($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach
</div>
@endif

<form method="POST" action="{{ url('/login') }}">
@csrf
<div class="form-group">
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="tu@email.com">
</div>
<div class="form-group">
<label>Contraseña</label>
<input type="password" name="password" required placeholder="••••••••">
</div>
<label class="remember">
<input type="checkbox" name="remember"> Recordarme
</label>
<button type="submit" class="btn">🔐 Iniciar Sesión</button>
</form>

<div class="demo-info">
<strong>Credenciales Demo:</strong><br>
Super Admin: admin@yfu.org.py<br>
Admin: coord@yfu.org.py<br>
Agente: agente@yfu.org.py<br>
Contraseña: <strong>password</strong>
</div>
</div>
</body>
</html>
