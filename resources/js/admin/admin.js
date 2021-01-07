/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.Vue = require('vue');


const feather = require('feather-icons');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
const EventFormComponent = Vue.component('event-form-component', require('./components/events/EventFormComponent.vue').default);

const StaffFilterComponent = Vue.component('staff-filter-component', require('./components/staff/StaffFilterComponent.vue').default);

const StaffFormComponent = Vue.component('staff-form-component', require('./components/staff/StaffFormComponent.vue').default);

const StaffTableComponent = Vue.component('staff-table-component', require('./components/staff/StaffTableComponent.vue').default);

const TeachingsFilterComponent = Vue.component('teachings-filter-component', require('./components/teachings/TeachingsFilterComponent.vue').default);

const TeachingsFormComponent = Vue.component('teachings-form-component', require('./components/teachings/TeachingsFormComponent.vue').default);

const TeachingTableComponent = Vue.component('teaching-table-component', require('./components/teachings/TeachingTableComponent.vue').default);

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

const app = new Vue({
    el: '#admin-app',

    components: {
        EventFormComponent,
        StaffFilterComponent,
        StaffFormComponent,
        StaffTableComponent,
        TeachingsFilterComponent,
        TeachingsFormComponent,
        TeachingTableComponent
    },

    mounted() {
        feather.replace();
    }

});



