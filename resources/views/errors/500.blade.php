<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Servidor en Llamas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #080000; color: #fff; font-family: 'Space Mono', monospace; height: 100vh; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        
        body::before { content: ""; position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%); background-size: 100% 4px; z-index: 100; pointer-events: none; }

        /* Partículas de fuego/chispas */
        .sparks { position: absolute; width: 100vw; height: 100vh; z-index: 1; }
        .spark { position: absolute; bottom: -10px; width: 4px; height: 15px; background: #ffaa00; border-radius: 50%; box-shadow: 0 0 10px #ff0000; animation: fly-up linear infinite; }
        .spark:nth-child(1) { left: 40%; animation-duration: 1s; animation-delay: 0s; }
        .spark:nth-child(2) { left: 50%; animation-duration: 0.8s; animation-delay: 0.2s; }
        .spark:nth-child(3) { left: 60%; animation-duration: 1.2s; animation-delay: 0.5s; }
        @keyframes fly-up { 0% { transform: translateY(0) scale(1); opacity: 1; } 100% { transform: translateY(-100vh) scale(0); opacity: 0; } }

        .container { position: relative; z-index: 10; text-align: center; max-width: 700px; padding: 40px; background: rgba(255,0,0,0.05); border: 2px solid #ff0000; border-radius: 20px; box-shadow: 0 0 80px rgba(255,0,0,0.4); animation: shake-screen 0.5s infinite; }
        @keyframes shake-screen { 0%, 100% { transform: translate(0, 0) rotate(0deg); } 25% { transform: translate(-2px, 2px) rotate(-1deg); } 75% { transform: translate(2px, -2px) rotate(1deg); } }

        /* Animación del Servidor Roto */
        .server-rack { width: 150px; margin-bottom: 20px; filter: drop-shadow(0 0 20px #f00); }
        
        h1 { font-size: 6rem; color: transparent; -webkit-text-stroke: 3px #ff0000; text-shadow: 0 0 30px #ff0000; margin-bottom: 10px; }
        h2 { font-size: 2rem; color: #fff; text-shadow: 0 0 15px #fff; margin-bottom: 20px; }
        p { font-size: 1.1rem; color: #ffcccc; margin-bottom: 40px; line-height: 1.6; }
        
        .btn { display: inline-block; padding: 15px 40px; color: #fff; background: #ff0000; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-radius: 5px; box-shadow: 0 0 30px #ff0000; transition: 0.3s; }
        .btn:hover { background: #ffaa00; box-shadow: 0 0 50px #ffaa00; transform: scale(1.05); color: #000; }
    </style>
</head>
<body>
    <div class="sparks">
        <div class="spark"></div><div class="spark"></div><div class="spark"></div>
    </div>
    <div class="container">
        <svg class="server-rack" viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="10" width="60" height="100" rx="5" fill="#110000" stroke="#ff0000" stroke-width="4"/>
            <circle cx="30" cy="30" r="5" fill="#ff0000">
                <animate attributeName="opacity" values="1;0;1" dur="0.1s" repeatCount="indefinite"/>
            </circle>
            <circle cx="50" cy="30" r="5" fill="#ff0000"/>
            <circle cx="70" cy="30" r="5" fill="#ff0000">
                <animate attributeName="opacity" values="1;0;1" dur="0.2s" repeatCount="indefinite"/>
            </circle>
            <path d="M20 50 L40 60 L30 80 L60 70 L50 90 L80 100" fill="none" stroke="#fff" stroke-width="3">
                <animate attributeName="stroke" values="#fff;#ffaa00;#ff0000" dur="0.3s" repeatCount="indefinite"/>
            </path>
            <path d="M40 60 Q50 30 60 60" fill="none" stroke="#ffaa00" stroke-width="4">
                <animate attributeName="d" values="M40 60 Q50 30 60 60; M40 60 Q50 10 60 60" dur="0.5s" repeatCount="indefinite"/>
            </path>
        </svg>
        <h1>500</h1>
        <h2>Falla Catastrófica del Núcleo</h2>
        <p>¡Mayday, Mayday! El servidor acaba de sufrir una sobrecarga de código. Los circuitos se derritieron. Evacúa esta página mientras el equipo técnico apaga el incendio.</p>
        <a href="{{ url('/home') }}" class="btn">Regresar al Menú Principal</a>
    </div>
</body>
</html>