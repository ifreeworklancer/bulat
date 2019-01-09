(function () {
  const params = {
    activeClass: 'is-active'
  };
  const selectors = document.querySelectorAll('.tabs-item');
  const image = document.querySelector('.tabs-image');

  Array.from(selectors).forEach(selector => {
    selector.addEventListener('click', () => {
      removeActiveClass();
      selector.classList.add(params.activeClass);
      image.style.backgroundImage = `url(${selector.dataset.image})`;
    });
  });

  function removeActiveClass() {
    Array.from(selectors).forEach(selector => {
      selector.classList.remove(params.activeClass);
    });
  }
})();