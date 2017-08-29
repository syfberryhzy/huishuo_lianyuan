
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./jQueryRotate');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('wechat', require('./components/WechatJSSDK.vue'));
Vue.component('turntable', require('./components/TurnTable.vue'));
Vue.component('answerchoose', require('./components/AnswerChoose.vue'));
Vue.component('redirect', require('./components/Redirect.vue'));

const app = new Vue({
    el: '#app',
    data() {
      return {
          li_h: 30,
          time: 2000,
          movetime: 1000,
          show: false
      }
    },
    mounted() {
      this.animated();
      this.slideUp();
    },
    methods: {
      cancelTimeShow() {
        this.show = false;
      },
      animated: function () {
        setTimeout(() => {
          $(".nan").addClass('animated fadeInLeftBig');
          $(".nv").addClass('animated fadeInRightBig');
        }, 200);

        setTimeout(() => {
          $(".pangbai").addClass('animated flipInY');
        }, 500);

        setTimeout(() => {
          $(".question-title").addClass('animated fadeInUpBig');
        }, 800);

        setTimeout(() => {
          $(".question-start").addClass('animated fadeInUpBig');
        }, 1100);

        setTimeout(() => {
          $(".question-rule").addClass('animated fadeInUpBig');
        }, 1400);

      	setTimeout(() => {
      	  this.show = true
      	}, 1700)
      },

      slideUp: function(){
  			//向上滑动动画
  			function autoani(){
  				$("li:first").animate({"margin-top":-this.li_h}, this.movetime, function () {
  					$(this).css("margin-top",0).appendTo(".line");
  				})
  			}

  			//自动间隔时间向上滑动
  			var anifun = setInterval(autoani, this.time);
  		}
    }
});
