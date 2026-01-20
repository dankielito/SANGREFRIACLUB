<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sangre Fría - Enlaces</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="EstructuraDispositivoMovil/css/indexDispositivoMovil.css">
    <link rel="stylesheet" href="EstructuraDispositivoMovil/css/contenedorNiveles.css">
    
    <link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/css/nivel1.css">
    <link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/css/nivel2.css">
</head>
<body>

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

    <script>
        // Función para abrir/cerrar los niveles
        function toggleModulo(id) {
            const contenido = document.getElementById(id);
            const header = contenido.previousElementSibling;
            const btn = header.querySelector('.btn-desplegar');
            
            if (contenido.classList.contains('active')) {
                contenido.classList.remove('active');
                if(btn) btn.innerText = "Desplegar";
            } else {
                contenido.classList.add('active');
                if(btn) btn.innerText = "Cerrar";
            }
        }

        // Función para navegar entre las 3 páginas
        function changePage(pageNum) {
            const pages = document.querySelectorAll('.page-content');
            const btns = document.querySelectorAll('.page-btn');

            // Ocultar todas las páginas
            pages.forEach(page => {
                page.style.display = 'none';
                page.classList.remove('active');
            });

            // Mostrar página seleccionada
            const activePage = document.getElementById('page-' + pageNum);
            activePage.style.display = 'block';
            
            // Efecto suave de aparición
            activePage.style.opacity = "0";
            setTimeout(() => {
                activePage.style.transition = "opacity 0.4s ease";
                activePage.style.opacity = "1";
            }, 10);

            // Activar botón correspondiente
            btns.forEach(btn => btn.classList.remove('active'));
            btns[pageNum - 1].classList.add('active');
        }
    </script>
</body>
</html>