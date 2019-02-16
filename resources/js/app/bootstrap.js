try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('@fancyapps/fancybox');
    require('bootstrap');
} catch (e) {}
