<footer class="main-footer"
    style="
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 24px;
        background: #2d3748;
        color: #a0aec0;
        border-top: 3px solid #c53030;
        font-size: 13px;
    "
>

    <!-- =========================
         Lado izquierdo:
         logo + información
    ========================== -->
    <div class="d-flex align-items-center" style="gap: 12px;">

        <!-- Caja del logo -->
        <div
            style="
                width: 44px;
                height: 44px;
                border-radius: 10px;
                background: rgb(255, 255, 255);
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                box-shadow: 0 2px 6px rgba(229,62,62,0.4);
                flex-shrink: 0;
            "
        >

            <!-- Imagen -->
            <img
                src="{{ asset('backend/dist/img/image_login.jpeg') }}"
                alt="Logo"
                style="
                    width: 38px;
                    height: 38px;
                    object-fit: contain;
                    padding: 3px;
                "
            >
        </div>

        <!-- Texto -->
        <div style="line-height: 1.4;">

            <div
                style="
                    color: #ffffff;
                    font-weight: 600;
                    font-size: 13px;
                "
            >
                Sistema de Compras
            </div>

            <div
                style="
                    font-size: 11px;
                    color: #718096;
                "
            >
                &copy; 2026 — Todos los derechos reservados.
            </div>

        </div>

    </div>

    <!-- =========================
         Lado derecho:
         versión sistema
    ========================== -->
    <div
        class="d-none d-sm-flex align-items-center"
        style="gap: 8px;"
    >

        <div
            style="
                background: rgba(255,255,255,0.07);
                border: 0.5px solid rgba(255,255,255,0.12);
                border-radius: 20px;
                padding: 4px 12px;
                font-size: 11px;
                color: #a0aec0;
            "
        >
            v 1.0.0
        </div>

    </div>

</footer>

<!-- =========================
     Sidebar derecho AdminLTE
========================= -->
<aside class="control-sidebar control-sidebar-dark">
</aside>