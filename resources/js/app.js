/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
import { Link } from '@inertiajs/inertia-vue';

if(document.getElementById('vue_app_content') !== null){
    
    InertiaProgress.init();
    
    Vue.component('Link',Link);
   
    Vue.component('pagination', require('laravel-vue-pagination'));
    
    if(typeof Swal !== undefined){

        Vue.prototype.toastAlert  = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });

    }
   
    createInertiaApp({
      id: 'vue_app_content',
      resolve: name => require(`./Pages/${name}`),
      setup({ el, App, props, plugin }) {
        Vue.use(plugin)
        new Vue({
          render: h => h(App, props),
        }).$mount(el)
      },
    })

} 
