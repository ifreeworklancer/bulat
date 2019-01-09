import Flickity from 'flickity'

(function () {
  const $homeCarousel = document.getElementById('home-slider');
  let $dots = [];
  let $arrows = [];

  if ($homeCarousel) {
    const $homeSlider = $homeCarousel.querySelector('.slider');
    $dots = Array.from($homeCarousel.querySelectorAll('.slider-nav-dot'));
    $arrows = Array.from($homeCarousel.querySelectorAll('.slider-nav-arrow'));

    const $slider = new Flickity($homeSlider, {
      prevNextButtons: false,
      pageDots: false,
      wrapAround: true
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