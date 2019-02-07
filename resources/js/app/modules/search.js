(function () {
  const searchButton = document.querySelector('[data-search]');
  const searchForm = document.querySelector('.nav .search');

  searchButton.addEventListener('click', (e) => {
    e.preventDefault();
    let icon = searchButton.innerText === 'search' ? 'close' : 'search';
    searchButton.innerText = icon;
    searchForm.classList.toggle('is-visible');
  })
})();