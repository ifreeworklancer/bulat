import lozad from 'lozad'

require('./bootstrap');
require('./modules/tabs');
require('./modules/sliders');

const observer = lozad();
observer.observe();
