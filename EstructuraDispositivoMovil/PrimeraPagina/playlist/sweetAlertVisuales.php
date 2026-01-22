<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/playlist/css/sweetAlertVisuales.css">

<script>
function mostrarDetalles(titulo, id, tipo, fecha, canal, duracion) {
    Swal.fire({
        title: `<span class="swal-congelado-titulo">${titulo}</span>`,
        html: `
            <div class="swal-neon-wrapper">
                <div class="swal-img-container">
                    <img src="https://img.youtube.com/vi/${id}/maxresdefault.jpg">
                    <span class="swal-badge">${duracion}</span>
                </div>
                <div class="swal-info-grid">
                    <p><strong><i class="fa-solid fa-video"></i> TIPO:</strong> ${tipo}</p>
                    <p><strong><i class="fa-solid fa-user-tie"></i> CANAL:</strong> ${canal}</p>
                    <p><strong><i class="fa-solid fa-calendar"></i> AÑO:</strong> ${fecha}</p>
                </div>
                <a href="https://youtu.be/${id}" target="_blank" class="swal-btn-yt">
                    <span class="btn-text">VER EN YOUTUBE</span>
                    <i class="fa-regular fa-snowflake"></i>
                </a>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        background: '#131517',
        customClass: {
            popup: 'swal-chasis-neon',
            closeButton: 'swal-close-btn'
        }
    });
}
</script>
