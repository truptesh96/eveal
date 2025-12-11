import { Lenis, Swiper, Navigation, Pagination } from './libs.js';

const swiper = new Swiper('.swiper', {
    modules: [Navigation, Pagination],
    loop: true,

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});


function enableInnerScroll(container) {
  container.addEventListener('wheel', (e) => {
    e.stopPropagation();
  });

  container.addEventListener('touchmove', (e) => {
    e.stopPropagation();
  });
}

(() => {
  const lenis = new Lenis({
    smooth: true,
    lerp: 0.15,    
    duration: 1,
    direction: 'vertical',
    autoRaf: true,
    anchors: {
        offset: 100,
        onComplete: ()=>{
        console.log('scrolled to anchor')
        }
    }
  });

  window.lenis = lenis;

  // Parallax effect initialization
  const parallaxEls = document.querySelectorAll('[data-speed]');
  const scrollContainers = document.querySelectorAll('dialog');

  scrollContainers.forEach((scrollContainer) => {
    enableInnerScroll(scrollContainer);
  });
 
  // Scroll handling
  lenis.on('scroll', ({ scroll }) => {
    updateParallax(parallaxEls, scroll);
  });

  window.lenis = lenis;
  
})();

// document.querySelectorAll('a[href^="#"]').forEach(el => {
//   el.addEventListener('click', e => {
//     e.preventDefault();
//     const targetId = el.getAttribute('href').slice(1);
//     const target = document.getElementById(targetId);
//     if (target) {
//       lenis.scrollTo(target, { 
//         duration: 1,
//         easing: t => 1 - Math.pow(1 - t, 3)
//       });
//     }
//   });
// });