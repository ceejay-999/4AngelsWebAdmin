import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

//plugins

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.js'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

//Components
import LayoutView from '../src/views/SharedLayoutView/LayoutView.vue';



const app = createApp(App)

app.use(router)

app.mount('#app')

//initailize components
app.component('LayoutView', LayoutView)


