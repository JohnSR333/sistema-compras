<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Sesión Agotada</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #000802; color: #fff; font-family: 'Space Mono', monospace; height: 100vh; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        
        body::before { content: ""; position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%); background-size: 100% 4px; z-index: 100; pointer-events: none; }

        /* Lluvia Matrix de fondo */
        .matrix { position: absolute; width: 100vw; height: 100vh; background: repeating-linear-gradient(180deg, transparent 0, rgba(0,255,100,0.1) 2px, transparent 4px); animation: fall 5s linear infinite; z-index: 1; opacity: 0.3; }
        @keyframes fall { 0% { background-position: 0 0; } 100% { background-position: 0 100vh; } }

        .container { position: relative; z-index: 10; text-align: center; max-width: 700px; padding: 40px; background: rgba(0,255,100,0.02); border: 1px solid #00ff66; border-radius: 20px; box-shadow: 0 0 40px rgba(0,255,100,0.2); }
        
        /* Animación de Batería */
        .battery { width: 120px; margin-bottom: 20px; filter: drop-shadow(0 0 15px #00ff66); }
        
        h1 { font-size: 6rem; color: transparent; -webkit-text-stroke: 2px #00ff66; text-shadow: 0 0 20px #00ff66; margin-bottom: 10px; }
        h2 { font-size: 2rem; color: #ccff00; text-shadow: 0 0 10px #ccff00; margin-bottom: 20px; }
        p { font-size: 1.1rem; color: #a3ccb3; margin-bottom: 40px; line-height: 1.6; }
        
        .btn { display: inline-block; padding: 15px 40px; color: #000; background: #00ff66; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-radius: 5px; box-shadow: 0 0 20px #00ff66; transition: 0.3s; }
        .btn:hover { background: #fff; box-shadow: 0 0 40px #fff; transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="matrix"></div>
    <div class="container">
        <svg class="battery" viewBox="0 0 100 150" xmlns="http://www.w3.org/2000/svg">
            <rect x="40" y="5" width="20" height="10" fill="#00ff66"/>
            <rect x="20" y="15" width="60" height="120" rx="5" fill="none" stroke="#00ff66" stroke-width="4"/>
            <rect x="25" y="25" width="50" height="20" fill="#00ff66">
                <animate attributeName="opacity" values="1;0;0" dur="4s" repeatCount="indefinite" />
            </rect>
            <rect x="25" y="55" width="50" height="20" fill="#00ff66">
                <animate attributeName="opacity" values="1;1;0" dur="4s" repeatCount="indefinite" />
            </rect>
            <rect x="25" y="85" width="50" height="20" fill="#00ff66">
                <animate attributeName="opacity" values="1;1;0" dur="4s" repeatCount="indefinite" />
            </rect>
            <rect x="25" y="115" width="50" height="15" fill="#f00">
                <animate attributeName="opacity" values="1;0;1" dur="0.5s" repeatCount="indefinite" />
            </rect>
        </svg>
        <h1>419</h1>
        <h2>Energía de Sesión Agotada</h2>
        <p>Tu tiempo de inactividad drenó toda la energía del token de seguridad. La cápsula se apagó para proteger tus datos. Necesitas recargar el sistema desde la central.</p>
        <a href="{{ url('/home') }}" class="btn">Regresar al Menú Principal</a>
    </div>
</body>
</html>