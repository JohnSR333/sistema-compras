<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Perdido en el Espacio</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #050510; color: #fff; font-family: 'Space Mono', monospace; height: 100vh; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        
        /* Efecto de pantalla de nave */
        body::before { content: ""; position: absolute; top: 0; left: 0; width: 100vw; height: 100vh; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06)); background-size: 100% 4px, 3px 100%; z-index: 100; pointer-events: none; }
        
        /* Estrellas moviéndose rápido */
        .stars { position: absolute; top: 0; left: 0; width: 200%; height: 100%; background: transparent url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><circle cx="20" cy="20" r="1.5" fill="%230ff"/><circle cx="150" cy="80" r="2" fill="%23f0f"/><circle cx="300" cy="200" r="1" fill="%23fff"/></svg>') repeat; animation: star-warp 20s linear infinite; z-index: 1; opacity: 0.6; }
        @keyframes star-warp { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        .container { position: relative; z-index: 10; text-align: center; max-width: 700px; padding: 40px; background: rgba(0,255,255,0.02); border: 1px solid rgba(0,255,255,0.2); border-radius: 20px; backdrop-filter: blur(5px); box-shadow: 0 0 50px rgba(0,255,255,0.1); }
        
        /* Animación del Astronauta */
        .astronaut { width: 180px; animation: float-space 6s ease-in-out infinite; filter: drop-shadow(0 0 15px rgba(0, 255, 255, 0.8)); }
        @keyframes float-space { 0%, 100% { transform: translateY(0) rotate(-5deg); } 50% { transform: translateY(-30px) rotate(5deg); } }

        h1 { font-size: 6rem; color: transparent; -webkit-text-stroke: 2px #0ff; text-shadow: 0 0 20px #0ff; margin-bottom: 10px; }
        h2 { font-size: 2rem; color: #f0f; text-shadow: 0 0 10px #f0f; margin-bottom: 20px; letter-spacing: 2px; }
        p { font-size: 1.1rem; color: #a0c0d0; margin-bottom: 40px; line-height: 1.6; }
        
        .btn { display: inline-block; padding: 15px 40px; color: #000; background: #0ff; text-decoration: none; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; border-radius: 5px; box-shadow: 0 0 20px #0ff; transition: 0.3s; cursor: pointer; }
        .btn:hover { background: #fff; box-shadow: 0 0 40px #fff; transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="container">
        <svg class="astronaut" viewBox="0 0 100 120" xmlns="http://www.w3.org/2000/svg">
            <path d="M50 10 C30 10 20 25 20 40 C20 60 30 70 50 70 C70 70 80 60 80 40 C80 25 70 10 50 10 Z" fill="#fff" stroke="#0ff" stroke-width="3"/>
            <rect x="30" y="25" width="40" height="25" rx="10" fill="#050510" stroke="#0ff" stroke-width="2"/>
            <path d="M20 50 L10 70 M80 50 L90 70 M40 70 L30 100 M60 70 L70 100" stroke="#fff" stroke-width="6" stroke-linecap="round"/>
            <circle cx="20" cy="10" r="5" fill="#f0f">
                <animate attributeName="opacity" values="1;0;1" dur="1s" repeatCount="indefinite"/>
            </circle>
            <path d="M50 70 Q40 90 60 110" fill="none" stroke="#0ff" stroke-width="2" stroke-dasharray="5 5">
                <animate attributeName="d" values="M50 70 Q40 90 60 110; M50 70 Q60 90 40 110; M50 70 Q40 90 60 110" dur="3s" repeatCount="indefinite"/>
            </path>
        </svg>
        <h1>404</h1>
        <h2>Ruta Perdida en el Vacío</h2>
        <p>Houston, la página que buscas no existe. Te saliste de la órbita del sistema y el cable de conexión se rompió. Inicia la secuencia de regreso.</p>
        <a href="{{ url('/home') }}" class="btn">Regresar al Menú Principal</a>
    </div>
</body>
</html>