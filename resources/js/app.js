import './bootstrap';
import 'admin-lte';
import 'admin-lte/dist/css/adminlte.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';

import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';

const app = createApp(App);
app.use(router);
app.mount('#app');