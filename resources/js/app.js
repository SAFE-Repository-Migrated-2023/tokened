//load Axios and lodash
require("./bootstrap");

import { createApp } from 'vue';
import App from './App.vue';
import Navbar from './components/Navbar.vue';
import ContactCardList from './components/ContactCardList.vue';

const app = createApp(App);

app.component('navbar', Navbar);
app.component('contact-card-list', ContactCardList);

app.mount('#app');