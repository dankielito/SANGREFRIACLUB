<script>
    function toggleModulo(id) {
        const contenido = document.getElementById(id);
        if (!contenido) return;
        
        const header = contenido.previousElementSibling;
        const btn = header ? header.querySelector('.btn-desplegar') : null;
        
        if (contenido.classList.contains('active')) {
            contenido.classList.remove('active');
            if(btn) btn.innerText = "Desplegar";
        } else {
            contenido.classList.add('active');
            if(btn) btn.innerText = "Cerrar";
        }
    }

    function changePage(pageNum) {
        const pages = document.querySelectorAll('.page-content');
        const btns = document.querySelectorAll('.page-btn');

        pages.forEach(page => {
            page.style.display = 'none';
            page.classList.remove('active');
        });

        const activePage = document.getElementById('page-' + pageNum);
        if (activePage) {
            activePage.style.display = 'block';
            activePage.style.opacity = "0";
            setTimeout(() => {
                activePage.style.transition = "opacity 0.4s ease";
                activePage.style.opacity = "1";
            }, 10);
        }

        btns.forEach(btn => btn.classList.remove('active'));
        if (btns[pageNum - 1]) {
            btns[pageNum - 1].classList.add('active');
        }
    }
</script>
