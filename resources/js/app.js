require('./bootstrap');
const Vue = require('vue');

$(document).ready(() => {
    M.AutoInit();
    $('.char-count').characterCounter();
})

Vue.component('create-module', require('./components/CreateModuleComponent.vue').default);
Vue.component('add-module-capability', require('./components/AddModuleCapabilityComponent.vue').default);
Vue.component('mystery-capability', require('./components/MysteryCapability.vue').default);
const app = new Vue({
    el: '#app'
});

