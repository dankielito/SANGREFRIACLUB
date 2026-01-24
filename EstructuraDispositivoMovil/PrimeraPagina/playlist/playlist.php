<?php
// Incluimos tu base de datos de categorías existente
include 'sweetAlertCategorias.php';

$playlist_id = 'PLfRglv5Ul9MgC6RNj-4BKTmaLnEWI4_oY';

function obtenerVideosPlaylist($id, $info_db) {
    $url = "https://www.youtube.com/playlist?list=" . $id;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);

    $videos = [];
    preg_match('/var ytInitialData = (.*?);<\/script>/', $html, $matches);
    
    if (isset($matches[1])) {
        $json = json_decode($matches[1], true);
        $tabs = $json['contents']['twoColumnBrowseResultsRenderer']['tabs'] ?? [];
        $contents = $tabs[0]['tabRenderer']['content']['sectionListRenderer']['contents'][0]['itemSectionRenderer']['contents'][0]['playlistVideoListRenderer']['contents'] ?? [];

        foreach ($contents as $item) {
            if (!isset($item['playlistVideoRenderer'])) continue;
            
            $v = $item['playlistVideoRenderer'];
            $video_id = $v['videoId'];
            $title = $v['title']['runs'][0]['text'] ?? 'Sin título';
            $canal = $v['shortBylineText']['runs'][0]['text'] ?? 'Artista Desconocido';

            $meta = $info_db[$video_id] ?? ['tipo' => 'Visual', 'fecha' => 'Fecha Reciente'];

            $videos[] = [
                "titulo" => trim(preg_replace('/\(Shot by.*?\)|Video Oficial|Oficial/i', '', $title)),
                "url"    => $video_id,
                "tipo"   => $meta['tipo'],
                "canal"  => $canal
            ];
        }
    }
    return $videos;
}

$videos = obtenerVideosPlaylist($playlist_id, $info_videos_db);
$categorias = ["TODOS", "3D", "Pixel Art", "Lyric", "Anime", "VideoClip"];

include 'sweetAlertPlaylist.php'; 
?>

<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/playlist.css">
<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/video.css">

<div class="cuerpo-movil-contenedor" id="portafolio-main-container">
    <div class="custom-playlist-container">
        <?php if (!empty($videos)): ?>
            
            <div id="main-player-area" class="main-playlist-card">
                <div class="video-responsive-container" id="video-wrapper">
                    <video id="intro-video-local" class="video-intro-estilo" autoplay muted loop playsinline>
                        <source src="EstructuraDispositivoMovil/PrimeraPagina/playlist/video/video.mp4" type="video/mp4">
                        Tu navegador no soporta video.
                    </video>
                </div>
                <div class="card-info">
                    <h3 id="player-title">SHOT BY DANKIEL | SANGRE FRIA</h3>
                </div>
            </div>

            <div class="category-selector polar-card">
                <button class="cat-btn" onclick="prevCat()"><i class="fa-solid fa-chevron-left"></i></button>
                <span id="current-cat">TODOS</span>
                <button class="cat-btn" onclick="nextCat()"><i class="fa-solid fa-chevron-right"></i></button>
            </div>

            <div class="video-scroll-list" id="video-list">
                <?php foreach ($videos as $index => $v): ?>
                    <div class="video-item polar-card" data-type="<?php echo $v['tipo']; ?>" id="video-<?php echo $index; ?>">
                        
                        <button class="btn-detalles" 
                                onclick="abrirInfoVideo('<?php echo addslashes($v['titulo']); ?>', '<?php echo $v['url']; ?>', '<?php echo addslashes($v['canal']); ?>')">
                            <i class="fa-solid fa-plus"></i>
                        </button>

                        <div class="video-clickable" onclick="reproducirVideo(document.getElementById('video-<?php echo $index; ?>'), '<?php echo $v['url']; ?>', '<?php echo addslashes($v['titulo']); ?>')">
                            <div class="video-details">
                                <span class="v-title"><?php echo $v['titulo']; ?></span>
                                <small style="display:block; color:var(--azul-claro); font-size:0.65rem; font-weight:bold; opacity:0.8;">
                                    <?php echo strtoupper($v['tipo']); ?>
                                </small>
                            </div>
                        </div>

                        <div class="rect-thumb-container" onclick="reproducirVideo(document.getElementById('video-<?php echo $index; ?>'), '<?php echo $v['url']; ?>', '<?php echo addslashes($v['titulo']); ?>')">
                            <img src="https://i.ytimg.com/vi/<?php echo $v['url']; ?>/mqdefault.jpg" class="thumb-list">
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// --- CONTROL DE RAM: Solo play si es visible ---
const videoLocal = document.getElementById('intro-video-local');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (videoLocal) {
            if (entry.isIntersecting) { videoLocal.play(); } 
            else { videoLocal.pause(); }
        }
    });
}, { threshold: 0.1 });

observer.observe(document.getElementById('portafolio-main-container'));

function reproducirVideo(elemento, id, titulo) {
    if(elemento && elemento.classList.contains('video-item')) {
        document.querySelectorAll('.video-item').forEach(v => v.classList.remove('selected-video'));
        elemento.classList.add('selected-video');
    }

    const wrapper = document.getElementById('video-wrapper');
    
    // Si el video local existe, lo pausamos antes de quitarlo
    if(videoLocal) videoLocal.pause();

    // Transición suave al iframe de YouTube
    wrapper.style.opacity = '0';
    setTimeout(() => {
        wrapper.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%; border-radius:18px;"></iframe>`;
        wrapper.style.opacity = '1';
    }, 300);

    document.getElementById('player-title').innerText = titulo;
    
    const playerArea = document.getElementById('main-player-area');
    window.scrollTo({
        top: playerArea.getBoundingClientRect().top + window.scrollY - 20,
        behavior: 'smooth'
    });
}

const cats = <?php echo json_encode($categorias); ?>;
let indexCat = 0;

function updatePlaylist() {
    const current = cats[indexCat];
    document.getElementById('current-cat').innerText = current;
    document.querySelectorAll('.video-item').forEach(item => {
        const typeTag = item.getAttribute('data-type').toUpperCase();
        item.style.display = (current === "TODOS" || typeTag.includes(current.toUpperCase())) ? "flex" : "none";
    });
}

function nextCat() { indexCat = (indexCat + 1) % cats.length; updatePlaylist(); }
function prevCat() { indexCat = (indexCat - 1 + cats.length) % cats.length; updatePlaylist(); }

document.addEventListener('DOMContentLoaded', updatePlaylist);
</script>