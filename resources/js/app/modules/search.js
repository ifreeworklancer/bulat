(function ($) {
  const searchButton = $('[data-search]');
  const searchForm = $('.nav .search');

  searchButton.on('click', (e) => {
    e.preventDefault();

    const icon = searchButton.text() === 'search' ? 'close' : 'search';
    searchButton.text(icon);

    searchForm.animate({
      top: icon === 'close' ? 0 : '-75px'
    });
  })
})(jQuery);