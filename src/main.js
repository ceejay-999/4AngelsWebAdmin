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
import FileView from '../src/views/FileManager.vue';
import AppointView from '../src/views/SharedLayoutView/AppointmentsCalendar.vue';
import FileMngr2 from '../src/views/SharedLayoutView/FileMngr2.vue';



const app = createApp(App)

app.use(router)

app.mount('#app')

//initailize components
app.component('LayoutView', LayoutView)
app.component('FileView', FileView)
app.component('AppointView', AppointView)
app.component('FileMngr2', FileMngr2)


