<main class="container">
    <div class="cuerpo-movil-contenedor">
        <header class="header-logos">
            <img src="img/Animacion/Cabeza.gif" alt="Sangre Fria">
            <img src="img/Animacion/CabezaBlackGengar.gif" alt="Gengar">
        </header>

        <div id="wrapper-paginas">
            <div id="page-1" class="page-content active">
                <?php include 'EstructuraDispositivoMovil/PrimeraPagina/nivel1.php'; ?>
                <?php include 'EstructuraDispositivoMovil/PrimeraPagina/nivel2.php'; ?>
                <?php include 'EstructuraDispositivoMovil/PrimeraPagina/nivel3.php'; ?>
                <?php include 'EstructuraDispositivoMovil/PrimeraPagina/nivel4.php'; ?>
            </div>

            <div id="page-2" class="page-content" style="display:none;">
                <div style="text-align:center; padding:50px; color:#78a6b5; opacity:0.6;">
                    <i class="fa-solid fa-layer-group" style="font-size:2rem;"></i>
                    <p>PÁGINA 2 EN DESARROLLO</p>
                </div>
            </div>

            <div id="page-3" class="page-content" style="display:none;">
                <div style="text-align:center; padding:50px; color:#78a6b5; opacity:0.6;">
                    <i class="fa-solid fa-circle-nodes" style="font-size:2rem;"></i>
                    <p>PÁGINA 3 EN DESARROLLO</p>
                </div>
            </div>
        </div>

        <?php include 'EstructuraDispositivoMovil/cambioPagina.php'; ?>
    </div>
</main>
