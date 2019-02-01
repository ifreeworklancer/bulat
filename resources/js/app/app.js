import Vue from 'vue'
import lozad from 'lozad'
import ImageUploader from './components/MultiImageUploader'

new Vue({
  el: '#app',
  components: {
    ImageUploader
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
