/*
 * Fichier JavaScript principal
 */

// CSS
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'animate.css/animate.min.css';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '../node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.min.css';

// JS Libraries (dans le bon ordre)
import 'jquery';
import 'jquery.easing';
import 'bootstrap';
import WOW from 'wow.js';
import Chart from 'chart.js/auto';
import '../node_modules/startbootstrap-sb-admin-2/js/sb-admin-2.min.js';
import Swiper from 'swiper';

// Initialisation WOW.js
new WOW({
  offset: 100, // distance de déclenchement
  mobile: true // activation sur mobile
}).init();

// Configuration globale
window.$ = window.jQuery = $; // jQuery global
window.Chart = Chart; // Chart.js global

// Initialisation conditionnelle des plugins SB Admin 2
$(document).ready(function() {
  // Vérifie l'existence des éléments avant d'initialiser
  const initSBAdminPlugins = () => {
      // Sidebar Toggle
      if ($('#sidebarToggle').length) {
          $('#sidebarToggle').on('click', function(e) {
              e.preventDefault();
              $('body').toggleClass('sidebar-toggled');
              $('.sidebar').toggleClass('toggled');
          });
      }

      // Tooltips
      if ($('[data-bs-toggle="tooltip"]').length) {
          $('[data-bs-toggle="tooltip"]').tooltip();
      }

      // Popovers
      if ($('[data-bs-toggle="popover"]').length) {
          $('[data-bs-toggle="popover"]').popover();
      }
  };

  // Délai d'initialisation pour s'assurer que le DOM est prêt
  setTimeout(initSBAdminPlugins, 100);
});

new WOW({
  mobile: false, // Désactive les animations sur mobile
  offset: 100 // Déclenchement plus tôt
}).init();




new Swiper('.swiper-slider-1', {
  loop: JSON.parse(document.querySelector('.swiper-slider-1').dataset.loop),
  autoplay: {
    delay: Number(document.querySelector('.swiper-slider-1').dataset.autoplay),
    disableOnInteraction: false
  },
  simulateTouch: JSON.parse(document.querySelector('.swiper-slider-1').dataset.simulateTouch),
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  }
});