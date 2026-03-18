<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Prueba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0a0f1c;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #111827;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #1f2937;
            width: 400px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #1f2937;
            background: #1e293b;
            color: white;
        }
        button {
            background: #0ea5e9;
            color: #0a0f1c;
            font-weight: bold;
            cursor: pointer;
        }
        .token {
            background: #1e293b;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            word-break: break-all;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Formulario de Prueba CSRF</h2>
        
        <div class="token">
            <strong>Token actual:</strong><br>
            {{ csrf_token() }}
        </div>
        
        <form method="POST" action="/importaciones">
            @csrf
            <input type="text" name="test" value="prueba" placeholder="Campo de prueba">
            <button type="submit">Enviar a /importaciones</button>
        </form>
        
        <hr>
        
        <form method="POST" action="/test-post" style="margin-top: 20px;">
            @csrf
            <input type="text" name="test" value="prueba" placeholder="Campo de prueba">
            <button type="submit">Enviar a /test-post</button>
        </form>
    </div>
</body>
</html>