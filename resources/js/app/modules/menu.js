(function () {
  const toggle = document.querySelector('[data-menu]');
  const close = document.querySelector('[data-menu-close]');
  const menu = document.querySelector('.menu');

  toggle.addEventListener('click', function (e) {
    e.preventDefault();
    menu.classList.add('is-active');
  });

  close.addEventListener('click', function (e) {
    e.preventDefault();
    menu.classList.remove('is-active');
  })
})();