import {createApp} from "vue/dist/vue.esm-bundler";
import AppComponent from "./components/App.vue"
import router from "./router/index";
import axios from "axios";
import VueAxios from "vue-axios";
import store from './store';

// axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

store.dispatch('getUser').then(()=>{
    createApp(AppComponent)
        .use(VueAxios, axios)
        .use(router)
        .use(store)
        .mount("#app");
})
