import Vue from 'vue';
window.Vue = Vue;


import './bootstrap';
import index from './components/index';

new Vue({
    el: '#app',
    components:{
        index
    }
});
