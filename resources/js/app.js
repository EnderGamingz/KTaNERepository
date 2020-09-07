require('./bootstrap');
const Vue = require('vue');

$(document).ready(() => {
    M.AutoInit();
    $('.char-count').characterCounter();
})

Vue.component('create-module', require('./components/CreateModuleComponent.vue').default);

const app = new Vue({
    el: '#app'
});

