<?php
// Base de datos corregida con miniaturas aseguradas (hqdefault)
$videos = [
    ["titulo" => "DE LA H, MAMI", "url" => "fdtGIXlSBYU", "tipo" => "Full EP/Album", "canal" => "Hurcker", "duracion" => "29:34", "fecha" => "2024"],
    ["titulo" => "Gráfica", "url" => "q-FcxH8VitQ", "tipo" => "3D Pixel Art", "canal" => "Young Shin", "duracion" => "3:05", "fecha" => "2024"],
    ["titulo" => "BROKEN", "url" => "1YhCMtuWXYI", "tipo" => "Pixel Art", "canal" => "Lifran", "duracion" => "3:35", "fecha" => "2024"],
    ["titulo" => "Tu + Yo= Error", "url" => "NyeYJHwbMgw", "tipo" => "Lyric Simple", "canal" => "YOUNG ALEEXX", "duracion" => "2:40", "fecha" => "2023"],
    ["titulo" => "No Vale La Pena RMX", "url" => "aEFW1vrqyBg", "tipo" => "3D Anime AMV", "canal" => "Chila", "duracion" => "3:20", "fecha" => "2024"],
    ["titulo" => "Armani", "url" => "yCIsKctKyyk", "tipo" => "3D", "canal" => "Peke Lex", "duracion" => "3:36", "fecha" => "2023"],
    ["titulo" => "BUENA VIDA", "url" => "HaEf63Wk1Sc", "tipo" => "Pixel Art", "canal" => "Young Shin", "duracion" => "2:30", "fecha" => "2024"],
    ["titulo" => "NO ME IMPORTA", "url" => "kSxN_uQF5EY", "tipo" => "3D", "canal" => "RAISS WAV", "duracion" => "6:48", "fecha" => "2024"],
    ["titulo" => "Tú 🤍 - DIEM MX", "url" => "q2YLSjHLPeY", "tipo" => "3D", "canal" => "DIEM MX", "duracion" => "3:33", "fecha" => "2024"],
    ["titulo" => "Otra Vez 💔", "url" => "gmlt0TecTZE", "tipo" => "3D Pixel Art", "canal" => "SANGRE FRIA", "duracion" => "2:44", "fecha" => "2024"],
    ["titulo" => "MIRAME", "url" => "ZRV_zPK18Gg", "tipo" => "Lyric Portada", "canal" => "Bhale", "duracion" => "3:28", "fecha" => "2023"],
    ["titulo" => "99 feat ROSI3", "url" => "9PfPgOhJJaA", "tipo" => "3D", "canal" => "SLEEZY OMG", "duracion" => "3:40", "fecha" => "2024"],
    ["titulo" => "Hablame", "url" => "ih8asyTq1oQ", "tipo" => "Pixel Art", "canal" => "Sick Lu", "duracion" => "2:36", "fecha" => "2024"],
    ["titulo" => "MALA", "url" => "toA7TAhdJQM", "tipo" => "Lyric Portada", "canal" => "RAISS WAV", "duracion" => "2:45", "fecha" => "2024"],
    ["titulo" => "Subeme La Nota", "url" => "Sx8w6pJpb3A", "tipo" => "Kinetic", "canal" => "Kidd Offi", "duracion" => "2:35", "fecha" => "2023"],
    ["titulo" => "Skinny", "url" => "azfkhwF1jGw", "tipo" => "3D Lyric", "canal" => "Kidd Offi", "duracion" => "1:07", "fecha" => "2023"],
    ["titulo" => "Xq M Evitas?", "url" => "x1RprL97HJs", "tipo" => "Lyric Simple", "canal" => "Kidd Offi", "duracion" => "2:13", "fecha" => "2023"],
    ["titulo" => "Thoughts", "url" => "ABS1KqO6Dro", "tipo" => "Lyric Portada", "canal" => "Peke Lex", "duracion" => "2:25", "fecha" => "2023"],
    ["titulo" => "LUNA", "url" => "xUnf5UXAW5g", "tipo" => "Anime AMV", "canal" => "nicco", "duracion" => "1:46", "fecha" => "2023"],
    ["titulo" => "CLAVE", "url" => "6h5MklJDZCk", "tipo" => "Lyric Portada", "canal" => "nicco", "duracion" => "2:16", "fecha" => "2023"],
    ["titulo" => "Contigo", "url" => "jzdxGmCmB_g", "tipo" => "Pixel Art", "canal" => "thayn", "duracion" => "1:33", "fecha" => "2024"],
    ["titulo" => "NUBES ☁️", "url" => "EAVGY5XqH6M", "tipo" => "VideoClip Edit", "canal" => "akarvcekid", "duracion" => "2:45", "fecha" => "2024"],
    ["titulo" => "OTRA NOCHE", "url" => "90OnAT9ELks", "tipo" => "VideoClip VFX", "canal" => "BlackSmok3", "duracion" => "2:13", "fecha" => "2024"]
];

$categorias = ["TODOS", "3D", "Pixel Art", "Lyric", "Anime", "VideoClip"];
include 'sweetAlertVisuales.php'; 
?>

<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/playlist.css">

<div class="playlist-neon-frame">
    <div class="custom-playlist-container">
        
        <div id="main-player-area" class="main-playlist-card">
            <div class="video-responsive-container" id="video-wrapper">
                <div class="card-img-wrapper" onclick="reproducirVideo('fdtGIXlSBYU', 'SHOT BY @DANKIEL', 'Toca para iniciar')">
                    <img src="https://img.youtube.com/vi/fdtGIXlSBYU/hqdefault.jpg" id="current-main-img">
                    <div class="card-overlay" style="opacity:1;">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                </div>
            </div>
            <div class="card-info" id="player-info">
                <h3 id="player-title">SHOT BY @DANKIEL</h3>
                <p id="player-subtitle">Lista de Reproducción Oficial</p>
            </div>
        </div>

        <div class="category-selector">
            <button onclick="prevCat()"><i class="fa-solid fa-chevron-left"></i></button>
            <span id="current-cat">TODOS</span>
            <button onclick="nextCat()"><i class="fa-solid fa-chevron-right"></i></button>
        </div>

        <div class="video-scroll-list" id="video-list">
            <?php foreach ($videos as $v): ?>
                <div class="video-item" data-type="<?php echo $v['tipo']; ?>">
                    <div class="video-clickable" onclick="reproducirVideo('<?php echo $v['url']; ?>', '<?php echo addslashes($v['titulo']); ?>', '<?php echo $v['canal']; ?>')">
                        <img src="https://img.youtube.com/vi/<?php echo $v['url']; ?>/hqdefault.jpg" alt="thumbnail">
                        <div class="video-details">
                            <span class="v-title"><?php echo $v['titulo']; ?></span>
                            <span class="v-tag"><?php echo $v['tipo']; ?></span>
                        </div>
                    </div>
                    <button class="btn-detalles" onclick="mostrarDetalles('<?php echo addslashes($v['titulo']); ?>', '<?php echo $v['url']; ?>', '<?php echo $v['tipo']; ?>', '<?php echo $v['fecha']; ?>', '<?php echo $v['canal']; ?>', '<?php echo $v['duracion']; ?>')">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
const cats = <?php echo json_encode($categorias); ?>;
let indexCat = 0;

function reproducirVideo(id, titulo, canal) {
    const wrapper = document.getElementById('video-wrapper');
    const info = document.getElementById('player-info');
    
    // Animación de Zoom Out
    wrapper.style.transform = "scale(0.95)";
    wrapper.style.opacity = "0.7";
    
    setTimeout(() => {
        wrapper.innerHTML = `
            <iframe src="https://www.youtube.com/embed/${id}?autoplay=1&rel=0&modestbranding=1" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        `;
        document.getElementById('player-title').innerText = titulo;
        document.getElementById('player-subtitle').innerText = canal;
        
        wrapper.style.transform = "scale(1)";
        wrapper.style.opacity = "1";
        info.classList.add('playing-mode');
    }, 300);
}

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