import Flickity from 'flickity'

(function () {
  const $carousel = document.querySelector('.slider');
  let $dots = [];
  let $arrows = [];

  if ($carousel) {
    $dots = Array.from(document.querySelectorAll('.slider-nav-dot'));
    $arrows = Array.from(document.querySelectorAll('.slider-nav-arrow'));

    const $slider = new Flickity($carousel, {
      prevNextButtons: false,
      pageDots: false,
      wrapAround: true,
      autoPlay: 4000,
      pauseAutoPlayOnHover: false
    });

    $dots.forEach(($dot, index) => {
      $dot.addEventListener('click', () => {
        handleDotsClass(index);
        $slider.select(index);
      })
    });

    $arrows.forEach(($arrow) => {
      $arrow.addEventListener('click', () => {
        $slider[$arrow.dataset.direction]();
      })
    });

    $slider.on('select', (index) => handleDotsClass(index));
  }

  function handleDotsClass(index) {
    $dots.forEach((d) => d.classList.remove('is-active'));
    $dots[index].classList.add('is-active');
  }
})();