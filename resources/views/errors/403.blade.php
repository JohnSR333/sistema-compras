<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Denegado</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #100000; color: #fff; font-family: 'Space Mono', monospace; height: 100vh; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        
        body::before { content: ""; position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%); background-size: 100% 4px; z-index: 100; pointer-events: none; }

        /* Luces de Alarma Rojas */
        .alarm { position: absolute; width: 100vw; height: 100vh; background: radial-gradient(circle, rgba(255,0,0,0.2) 0%, transparent 70%); animation: flash 1.5s infinite alternate; z-index: 1; }
        @keyframes flash { 0% { opacity: 0.2; } 100% { opacity: 0.8; } }

        .container { position: relative; z-index: 10; text-align: center; max-width: 700px; padding: 40px; background: rgba(255,0,0,0.05); border: 2px solid #f00; border-radius: 20px; box-shadow: 0 0 50px rgba(255,0,0,0.5); }
        
        /* Animación del Escudo Holográfico */
        .shield { width: 160px; filter: drop-shadow(0 0 20px #f00); animation: pulse-shield 0.5s infinite alternate; }
        @keyframes pulse-shield { 0% { transform: scale(1); opacity: 0.8; } 100% { transform: scale(1.05); opacity: 1; } }

        h1 { font-size: 6rem; color: transparent; -webkit-text-stroke: 3px #f00; text-shadow: 0 0 30px #f00; margin-bottom: 10px; animation: glitch 0.2s infinite; }
        h2 { font-size: 2rem; color: #ffaa00; text-shadow: 0 0 10px #ffaa00; margin-bottom: 20px; }
        p { font-size: 1.1rem; color: #ffcccc; margin-bottom: 40px; line-height: 1.6; }
        
        .btn { display: inline-block; padding: 15px 40px; color: #fff; background: #f00; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-radius: 5px; box-shadow: 0 0 20px #f00; transition: 0.3s; }
        .btn:hover { background: #ffaa00; box-shadow: 0 0 40px #ffaa00; transform: scale(1.05); color: #000; }
    </style>
</head>
<body>
    <div class="alarm"></div>
    <div class="container">
        <svg class="shield" viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 10 L10 30 L10 60 C10 90 50 110 50 110 C50 110 90 90 90 60 L90 30 Z" fill="rgba(255,0,0,0.2)" stroke="#f00" stroke-width="4"/>
            <circle cx="50" cy="55" r="20" fill="none" stroke="#fff" stroke-width="4"/>
            <line x1="36" y1="41" x2="64" y2="69" stroke="#fff" stroke-width="4"/>
            <ellipse cx="50" cy="55" rx="35" ry="45" fill="none" stroke="#f00" stroke-width="1">
                <animate attributeName="rx" values="35;60;35" dur="1s" repeatCount="indefinite"/>
                <animate attributeName="ry" values="45;70;45" dur="1s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values="1;0;1" dur="1s" repeatCount="indefinite"/>
            </ellipse>
        </svg>
        <h1>403</h1>
        <h2>Campos de Fuerza Activos</h2>
        <p>¡Alto ahí, parcero! No tienes el nivel de acceso requerido. El escudo de seguridad bloqueó tu solicitud. Regresa inmediatamente a tu zona autorizada.</p>
        <a href="{{ url('/home') }}" class="btn">Regresar al Menú Principal</a>
    </div>
</body>
</html>