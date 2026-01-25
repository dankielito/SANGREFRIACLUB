<?php
// Base de datos manual para videos ocultos
$videos_ocultos = [
    ["titulo" => "VIDEO EXCLUSIVO 1", "archivo" => "video1.mp4", "tipo" => "3D", "canal" => "Dankiel"],
    ["titulo" => "VIDEO EXCLUSIVO 2", "archivo" => "video2.mp4", "tipo" => "Pixel Art", "canal" => "Dankiel"],
    ["titulo" => "VIDEO EXCLUSIVO 3", "archivo" => "video3.mp4", "tipo" => "Lyric", "canal" => "Dankiel"],
    ["titulo" => "VIDEO EXCLUSIVO 4", "archivo" => "video4.mp4", "tipo" => "Anime", "canal" => "Dankiel"],
    ["titulo" => "VIDEO EXCLUSIVO 5", "archivo" => "video5.mp4", "tipo" => "VideoClip", "canal" => "Dankiel"],
];

$categorias_ocultas = ["TODOS", "3D", "Pixel Art", "Lyric", "Anime", "VideoClip"];

// RUTAS CORREGIDAS PARA EL NAVEGADOR
// Ruta para los videos de la lista (dentro de su propia carpeta video)
$ruta_videos_lista = "EstructuraDispositivoMovil/PrimeraPagina/Nivel4/ocultosEliminados/video/";
// Ruta compartida del video de intro (está en la carpeta playlist)
$ruta_video_intro = "EstructuraDispositivoMovil/PrimeraPagina/Nivel4/playlist/video/video.mp4";
// Imagen de miniatura compartida
$thumb_prueba = "EstructuraDispositivoMovil/PrimeraPagina/Nivel4/playlist/img/nubes.jpg"; 
?>

<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/Nivel4/ocultosEliminados/css/OcultosEliminados.css">
<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/Nivel4/playlist/css/video.css">

<div class="cuerpo-movil-contenedor" id="portafolio-oculto-container">
    <div class="custom-playlist-container">
        
        <div id="player-area-oculto" class="main-playlist-card">
            <div class="video-responsive-container" id="video-wrapper-oculto">
                <video id="video-principal-oculto" class="video-intro-estilo" autoplay muted loop playsinline>
                    <source src="<?php echo $ruta_video_intro; ?>" type="video/mp4">
                    Tu navegador no soporta video.
                </video>
            </div>
            <div class="card-info">
                <h3 id="player-title-oculto">ARCHIVO ELIMINADO | VIDEO 1</h3>
            </div>
        </div>

        <div class="category-selector polar-card">
            <button class="cat-btn" onclick="prevCatOculto()"><i class="fa-solid fa-chevron-left"></i></button>
            <span id="current-cat-oculto">TODOS</span>
            <button class="cat-btn" onclick="nextCatOculto()"><i class="fa-solid fa-chevron-right"></i></button>
        </div>

        <div class="video-scroll-list" id="video-list-oculto">
            <?php foreach ($videos_ocultos as $index => $v): ?>
                <div class="video-item polar-card item-oculto" data-type="<?php echo $v['tipo']; ?>" id="v-oculto-<?php echo $index; ?>">
                    
                    <button class="btn-detalles" onclick="alert('Video Local: <?php echo $v['titulo']; ?>')">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <div class="video-clickable" onclick="reproducirVideoLocal(this, '<?php echo $ruta_videos_lista . $v['archivo']; ?>', '<?php echo $v['titulo']; ?>')">
                        <div class="video-details">
                            <span class="v-title"><?php echo $v['titulo']; ?></span>
                            <small style="display:block; color:#78a6b5; font-size:0.65rem; font-weight:bold; opacity:0.8;">
                                <?php echo strtoupper($v['tipo']); ?>
                            </small>
                        </div>
                    </div>

                    <div class="rect-thumb-container" onclick="reproducirVideoLocal(this.parentElement, '<?php echo $ruta_videos_lista . $v['archivo']; ?>', '<?php echo $v['titulo']; ?>')">
                        <img src="<?php echo $thumb_prueba; ?>" class="thumb-list">
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function reproducirVideoLocal(elemento, ruta, titulo) {
    // Marcar el item como seleccionado visualmente
    document.querySelectorAll('.item-oculto').forEach(v => v.classList.remove('selected-video'));
    
    // Si se hace click en el contenedor de miniatura, el 'elemento' es el padre
    const itemTarget = elemento.classList.contains('item-oculto') ? elemento : elemento.closest('.item-oculto');
    if(itemTarget) itemTarget.classList.add('selected-video');

    const wrapper = document.getElementById('video-wrapper-oculto');
    
    // Transición de salida
    wrapper.style.opacity = '0';

    setTimeout(() => {
        // Inyectamos el nuevo video con controles activados
        wrapper.innerHTML = `
            <video class="video-intro-estilo" autoplay controls style="position:absolute; top:0; left:0; width:100%; height:100%; border-radius:18px; object-fit:cover;">
                <source src="${ruta}" type="video/mp4">
            </video>`;
        wrapper.style.opacity = '1';
    }, 300);

    document.getElementById('player-title-oculto').innerText = titulo;
}

// Lógica de navegación de categorías exclusiva para Ocultos
const catsOcultoData = <?php echo json_encode($categorias_ocultas); ?>;
let idxCatOcultoActual = 0;

function updatePlaylistOculto() {
    const current = catsOcultoData[idxCatOcultoActual];
    const catDisplay = document.getElementById('current-cat-oculto');
    if(catDisplay) catDisplay.innerText = current;

    document.querySelectorAll('.item-oculto').forEach(item => {
        const typeTag = item.getAttribute('data-type').toUpperCase();
        item.style.display = (current === "TODOS" || typeTag.includes(current.toUpperCase())) ? "flex" : "none";
    });
}

function nextCatOculto() { 
    idxCatOcultoActual = (idxCatOcultoActual + 1) % catsOcultoData.length; 
    updatePlaylistOculto(); 
}

function prevCatOculto() { 
    idxCatOcultoActual = (idxCatOcultoActual - 1 + catsOcultoData.length) % catsOcultoData.length; 
    updatePlaylistOculto(); 
}

// Inicializar la lista
document.addEventListener('DOMContentLoaded', updatePlaylistOculto);
</script>