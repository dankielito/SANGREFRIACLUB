<link rel="stylesheet" href="EstructuraDispositivoMovil/PrimeraPagina/live/css/live.css">

<div class="live-master-wrapper">
    <button class="live-switch-btn" onclick="nextLive()" title="Siguiente canal">
        <i class="fa-solid fa-arrow-rotate-right"></i>
    </button>

    <div class="live-slider" id="liveSlider">
        
        <div class="live-slide active">
            <iframe src="https://kick.com/dankiel" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="live-slide">
            <div class="proximamente-container yt-bg">
                <div class="proximamente-content">
                    <i class="fa-brands fa-youtube"></i>
                    <h2>DANKIEL</h2>
                    <p>PRÓXIMAMENTE</p>
                </div>
            </div>
        </div>

        <div class="live-slide">
            <div class="proximamente-container yt-bg">
                <div class="proximamente-content">
                    <i class="fa-brands fa-youtube"></i>
                    <h2>DANKIELITO</h2>
                    <p>PRÓXIMAMENTE</p>
                </div>
            </div>
        </div>

    </div>

    <div class="live-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.live-slide');
    const dots = document.querySelectorAll('.dot');
    let autoSwap = setInterval(nextLive, 10000); // 10 segundos para cada uno

    function nextLive() {
        // Quitar clases actuales
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        
        // Siguiente slide (ciclo infinito)
        currentSlide = (currentSlide + 1) % slides.length;
        
        // Añadir clases al nuevo slide
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        
        // Reiniciar el contador automático
        clearInterval(autoSwap);
        autoSwap = setInterval(nextLive, 10000);
    }
</script>