<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function abrirInfoVideo(titulo, id, tipo, canal) {
    Swal.fire({
        background: '#1a1c1e',
        color: '#fff',
        width: '350px',
        showConfirmButton: false,
        showCloseButton: true,
        html: `
            <div style="padding: 10px; text-align: center;">
                <h3 style="color:#78a6b5; text-transform:uppercase; font-size:1.1rem; margin-bottom:15px;">${titulo}</h3>
                
                <div style="position:relative; margin-bottom:20px; border-radius:15px; overflow:hidden; border:2px solid #78a6b5;">
                    <img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg" style="width:100%; display:block;">
                    
                    <div onclick="verMiniaturaGigante('${id}')" style="position:absolute; bottom:10px; right:10px; background:#78a6b5; color:white; width:35px; height:35px; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 0 10px rgba(0,0,0,0.5);">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </div>
                </div>

                <div style="text-align:left; background:rgba(255,255,255,0.05); padding:15px; border-radius:10px; font-family:sans-serif; font-size:0.85rem;">
                    <p style="margin:5px 0;"><i class="fa-solid fa-user" style="color:#78a6b5; width:20px;"></i> <b>Artista:</b> ${canal}</p>
                    <p style="margin:5px 0;"><i class="fa-solid fa-layer-group" style="color:#78a6b5; width:20px;"></i> <b>Categoría:</b> ${tipo}</p>
                    <p style="margin:5px 0;"><i class="fa-solid fa-clapperboard" style="color:#78a6b5; width:20px;"></i> <b>Visuales:</b> Shot by Dankiel</p>
                </div>

                <a href="https://www.youtube.com/watch?v=${id}" target="_blank" style="display:inline-block; margin-top:20px; color:#78a6b5; text-decoration:none; font-weight:900; font-size:0.75rem; border:1px solid #78a6b5; padding:8px 20px; border-radius:20px;">
                    VER EN YOUTUBE <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        `
    });
}

// Función secundaria para la Lupa (Zoom de imagen)
function verMiniaturaGigante(id) {
    Swal.fire({
        imageUrl: `https://i.ytimg.com/vi/${id}/maxresdefault.jpg`,
        imageAlt: 'Thumbnail HD',
        background: 'rgba(0,0,0,0.9)',
        backdrop: 'rgba(0,0,0,0.8)',
        showConfirmButton: false,
        showCloseButton: true,
        width: '80%'
    });
}
</script>

<style>
/* Estilo para el botón plus de la lista */
.btn-detalles:hover {
    transform: rotate(90deg) scale(1.1);
    background: #1a1c1e !important;
    transition: all 0.3s ease;
}
</style>