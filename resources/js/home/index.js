import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../components/home/Home.vue';
import RouterView from '../components/home/RouterView.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
});


new Vue({
    el: '#home-main-content',
    router,
    render: h => h(RouterView),
});
