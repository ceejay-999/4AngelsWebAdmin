import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//plugins
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import '../src/assets/plugins/jquery/jquery.min.js';
import '../src/assets/bootstrap/js/bootstrap.bundle.min.js'
import '../src/assets/plugins/simplebar/simplebar.min.js';
import '../src/assets/js/sleek.js';

//Components
import LayoutView from '../src/views/SharedLayoutView/LayoutView.vue';



const app = createApp(App)

app.use(router)

app.mount('#app')

//initailize components
app.component('LayoutView', LayoutView)