require('./bootstrap');
require('simplebar');
import 'simplebar/dist/simplebar.css';

import Editor from './components/Editor';

new Vue({
  el: '#app',
  components: {
    ...Editor,
  },
  mounted() {
    require('./modules/notifications');
    require('./modules/phone-mask');
  }
});
