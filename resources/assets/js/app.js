
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('answerchoose', require('./components/AnswerChoose.vue'));

const app = new Vue({
    el: '#app',
    mounted() {
      this.animated();
    },
    methods: {
      animated: function () {
        setTimeout(() => {
          $(".nan").addClass('animated fadeInLeftBig');
          $(".nv").addClass('animated fadeInRightBig');
        }, 200);

        setTimeout(() => {
          $(".pangbai").addClass('animated flipInY');
        }, 300);

        setTimeout(() => {
          $(".question-title").addClass('animated fadeInUpBig');
        }, 400);

        setTimeout(() => {
          $(".question-start").addClass('animated fadeInUpBig');
        }, 500);

        setTimeout(() => {
          $(".question-rule").addClass('animated fadeInUpBig');
        }, 600);
      }
    }
});
