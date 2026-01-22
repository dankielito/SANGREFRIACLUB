<?php
$playlist_id = 'PLfRglv5Ul9MgC6RNj-4BKTmaLnEWI4_oY';

function obtenerVideosPlaylist($id) {
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
            $title = $v['title']['runs'][0]['text'] ?? 'Sin título';
            $video_id = $v['videoId'];
            $canal = $v['shortBylineText']['runs'][0]['text'] ?? 'Artista Desconocido';

            $tipo = "Visual";
            if (stripos($title, '3D') !== false) $tipo = "3D";
            elseif (stripos($title, 'Pixel') !== false) $tipo = "Pixel Art";
            elseif (stripos($title, 'Lyric') !== false) $tipo = "Lyric";

            $videos[] = [
                "titulo" => trim(preg_replace('/\(Shot by.*?\)|Video Oficial|Oficial/i', '', $title)),
                "url"    => $video_id,
                "tipo"   => $tipo,
                "canal"  => $canal
            ];
        }
    }
    return $videos;
}

$videos = obtenerVideosPlaylist($playlist_id);
$categorias = ["TODOS", "3D", "Pixel Art", "Lyric"];

include 'sweetAlertPlaylist.php'; 
?>

<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/playlist.css">

<div class="cuerpo-movil-contenedor">
    <div class="custom-playlist-container">
        <?php if (!empty($videos)): ?>
            
            <div id="main-player-area" class="main-playlist-card">
                <div class="video-responsive-container" id="video-wrapper">
                    <div class="card-img-wrapper" onclick="reproducirVideo(this, '<?php echo $videos[0]['url']; ?>', '<?php echo addslashes($videos[0]['titulo']); ?>')">
                        <img src="https://i.ytimg.com/vi/<?php echo $videos[0]['url']; ?>/hqdefault.jpg">
                        <div class="card-overlay">
                            <i class="fa-solid fa-circle-play"></i>
                        </div>
                    </div>
                </div>
                <div class="card-info">
                    <h3 id="player-title"><?php echo $videos[0]['titulo']; ?></h3>
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
                                onclick="abrirInfoVideo('<?php echo addslashes($v['titulo']); ?>', '<?php echo $v['url']; ?>', '<?php echo $v['tipo']; ?>', '<?php echo addslashes($v['canal']); ?>')">
                            <i class="fa-solid fa-plus"></i>
                        </button>

                        <div class="video-clickable" onclick="reproducirVideo(document.getElementById('video-<?php echo $index; ?>'), '<?php echo $v['url']; ?>', '<?php echo addslashes($v['titulo']); ?>')">
                            <div class="video-details">
                                <span class="v-title"><?php echo $v['titulo']; ?></span>
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
function reproducirVideo(elemento, id, titulo) {
    if(elemento && elemento.classList.contains('video-item')) {
        elemento.classList.add('selected-video');
        setTimeout(() => elemento.classList.remove('selected-video'), 600);
    }

    const wrapper = document.getElementById('video-wrapper');
    wrapper.innerHTML = `<iframe src="https://www.youtube.com/embed/${id}?autoplay=1&rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%;"></iframe>`;
    document.getElementById('player-title').innerText = titulo;
}

const cats = <?php echo json_encode($categorias); ?>;
let indexCat = 0;

function updatePlaylist() {
    const current = cats[indexCat];
    document.getElementById('current-cat').innerText = current;
    document.querySelectorAll('.video-item').forEach(item => {
        const type = item.getAttribute('data-type').toUpperCase();
        item.style.display = (current === "TODOS" || type.includes(current.toUpperCase())) ? "flex" : "none";
    });
}
function nextCat() { indexCat = (indexCat + 1) % cats.length; updatePlaylist(); }
function prevCat() { indexCat = (indexCat - 1 + cats.length) % cats.length; updatePlaylist(); }
</script>