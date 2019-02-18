import Vue from 'vue'
import lozad from 'lozad'
// import checkView from 'vue-check-view'

import ImagesUploader from './components/MultiImageUploader';
// import ProductsList from './components/products-list/ProductsList';

// Vue.use(checkView);

new Vue({
  el: '#app',
  components: {
    ImagesUploader,
    // ProductsList
  },
  mounted() {
    require('./bootstrap');
    require('./modules/tabs');
    require('./modules/sliders');
    require('./modules/search');
    require('./modules/menu');

    const observer = lozad();
    observer.observe();
  }
});
