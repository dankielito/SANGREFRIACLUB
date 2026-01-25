<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/Nivel4/css/nivel4.css">

<div class="separador-brillante"></div>

<section class="modulo">
    <div class="modulo-header" onclick="toggleModulo('visuales')">
        <span>VISUALES (PORTAFOLIO)</span>
        <button class="btn-desplegar" id="btn-txt-4">Desplegar</button>
    </div>
    
    <div class="modulo-contenido" id="visuales">
        <div class="snow-container">
            <div class="snow"></div><div class="snow"></div><div class="snow"></div>
            <div class="snow"></div><div class="snow"></div><div class="snow"></div>
        </div>

        <a href="https://wa.me/tu-numero" target="_blank" class="btn-comprar-visuales">
            <span class="texto-congelado">Comprar Visuales</span>
        </a>

        <div class="contenedor-selector-portafolio">
            <button id="btn-tab-activos" class="tab-btn active" onclick="cambiarPortafolio('activos')">
                VISUALES ACTIVOS
            </button>
            <button id="btn-tab-ocultos" class="tab-btn" onclick="cambiarPortafolio('ocultos')">
                VISUALES OCULTOS
            </button>
        </div>

        <div id="wrapper-activos" class="wrapper-contenido-visual">
            <?php include 'playlist/playlist.php'; ?>
        </div>

        <div id="wrapper-ocultos" class="wrapper-contenido-visual" style="display: none;">
            <?php include 'ocultosEliminados/OcultosEliminados.php'; ?>
        </div>
    </div>
</section>

<script>
function cambiarPortafolio(tipo) {
    const wrapperActivos = document.getElementById('wrapper-activos');
    const wrapperOcultos = document.getElementById('wrapper-ocultos');
    const btnActivos = document.getElementById('btn-tab-activos');
    const btnOcultos = document.getElementById('btn-tab-ocultos');

    if (tipo === 'activos') {
        wrapperActivos.style.display = 'block';
        wrapperOcultos.style.display = 'none';
        btnActivos.classList.add('active');
        btnOcultos.classList.remove('active');

        // Pausar video local si existe al cambiar de pestaña
        const videoLocal = document.getElementById('video-principal-oculto');
        if(videoLocal) videoLocal.pause();
    } else {
        wrapperActivos.style.display = 'none';
        wrapperOcultos.style.display = 'block';
        btnOcultos.classList.add('active');
        btnActivos.classList.remove('active');

        // Play video local al entrar a la pestaña de ocultos
        const videoLocal = document.getElementById('video-principal-oculto');
        if(videoLocal) videoLocal.play();
    }
}
</script>