import lozad from 'lozad'

require('./bootstrap');
require('./modules/tabs');
require('./modules/sliders');
require('./modules/search');

const observer = lozad();
observer.observe();
