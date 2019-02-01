import Vue from 'vue'
import lozad from 'lozad'
import ImagesUploader from './components/MultiImageUploader'

new Vue({
  el: '#app',
  components: {
    ImagesUploader
  },
  mounted() {
    require('./bootstrap');
    require('./modules/tabs');
    require('./modules/sliders');
    require('./modules/search');

    const observer = lozad();
    observer.observe();
  }
});
