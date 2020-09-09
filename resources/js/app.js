require('./bootstrap');
const Vue = require('vue');

$(document).ready(() => {
    M.AutoInit();
    $('.char-count').characterCounter();
})

Vue.component('create-module', require('./components/CreateModuleComponent.vue').default);
Vue.component('add-module-capability', require('./components/AddModuleCapabilityComponent.vue').default);
Vue.component('mystery-capability', require('./components/MysteryCapability.vue').default);
Vue.component('boss-module-capability', require('./components/BossModuleCapability.vue').default);
Vue.component('souvenir-capability', require('./components/SouvenirCapability.vue').default);
Vue.component('rule-seed-capability', require('./components/RuleSeedCapability.vue').default);
Vue.component('maintainer-manager', require('./components/MaintainerManagerComponent.vue').default);

const app = new Vue({
    el: '#app'
});

