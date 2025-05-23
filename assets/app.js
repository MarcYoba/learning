/*
 * Fichier JavaScript principal - Version corrigée
 */

// CSS (ordre optimisé)
import 'bootstrap/dist/css/bootstrap.min.css'; // Bootstrap en premier
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'animate.css/animate.min.css';
import 'startbootstrap-sb-admin-2/css/sb-admin-2.min.css'; // Chemin corrigé
import './styles/app.css'; // Styles personnalisés en dernier

// JS Libraries (ordre de dépendance corrigé)
import $ from 'jquery';
import 'jquery.easing';
import 'bootstrap'; // Après jQuery
import { Tooltip, Popover } from 'bootstrap'; // Import spécifique Bootstrap
import Swiper from 'swiper';
import  WOW  from 'wow.js';

import Chart from 'chart.js/auto';
import 'startbootstrap-sb-admin-2/js/sb-admin-2.min.js'; // Chemin corrigé
// Configuration globale
window.$ = window.jQuery = $; // Déclaration globale nécessaire pour SB Admin

// Initialisation WOW.js (une seule instance)
const wow = new WOW({
  offset: 100,
  mobile: true,
  live: true // Ajout recommandé pour le rechargement dynamique
});
wow.init();

// Initialisation des composants
// $(document).ready(function() {
//   // Sidebar Toggle
//   $('#sidebarToggle').on('click', function(e) {
//     e.preventDefault();
//     $('body').toggleClass('sidebar-toggled');
//     $('.sidebar').toggleClass('toggled');
//   });

//   // Tooltips (avec vérification d'existence)
//   if (document.querySelector('[data-bs-toggle="tooltip"]')) {
//     Tooltip.init(document.body, {
//       selector: '[data-bs-toggle="tooltip"]'
//     });
//   }

//   // Popovers (avec vérification d'existence)
//   if (document.querySelector('[data-bs-toggle="popover"]')) {
//     Popover.init(document.body, {
//       selector: '[data-bs-toggle="popover"]'
//     });
//   }
// });

// Configuration Swiper améliorée
document.querySelectorAll('.swiper-slider-1').forEach(container => {
  new Swiper(container, {
    loop: JSON.parse(container.dataset.loop),
    autoplay: {
      delay: Number(container.dataset.autoplay),
      disableOnInteraction: false
    },
    simulateTouch: JSON.parse(container.dataset.simulateTouch),
    modules: [Navigation], // Adaptation à Swiper 8+
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });
});