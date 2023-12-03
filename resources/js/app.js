import './bootstrap';
import 'bootstrap/dist/js/bootstrap.min.js'
import './sidebars'


document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const contentMain = document.querySelector('.content-main');
    const mainContent = document.querySelector('.main-content'); // Aggiunto questo

    document.getElementById('sidebarToggle').addEventListener('click', function () {
        sidebar.classList.toggle('active');
        contentMain.classList.toggle('sidebar-active');
        
        // Aggiunta la logica per nascondere o mostrare il contenuto principale
        if (sidebar.classList.contains('active')) {
            mainContent.style.display = 'none';
        } else {
            mainContent.style.display = 'block';
        }
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.sidebar') && !event.target.closest('#sidebarToggle')) {
            sidebar.classList.remove('active');
            contentMain.classList.remove('sidebar-active');
            mainContent.style.display = 'block'; // Mostra il contenuto principale al di fuori della sidebar
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 991.98) {
            sidebar.classList.remove('active');
            contentMain.classList.remove('sidebar-active');
            mainContent.style.display = 'block'; // Mostra il contenuto principale quando la finestra è sufficientemente larga
        }
    });
});
