require('./bootstrap');

import DataTables from './components/DataTables';
import Editor from './components/Editor';

new Vue({
  el: '#app',
  components: {
    ...DataTables,
    ...Editor,
  },
  mounted() {
    require('./modules/notifications');
    require('./modules/phone-mask');
  }
});
