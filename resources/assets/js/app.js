
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
          show: false,
          config: window.jssdk,
          list: window.jsapilist
      }
    },
    mounted() {
      this.animated();
      this.slideUp();
      this.wechatInit();
    },
    methods: {
      wechatInit() {
          window.wx.config({
              debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
              appId: this.config.appId, // 必填，公众号的唯一标识
              timestamp: this.config.timestamp, // 必填，生成签名的时间戳
              nonceStr: this.config.nonceStr, // 必填，生成签名的随机串
              signature: this.config.signature,// 必填，签名，见附录1
              jsApiList: [
  		          ...this.list
              ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
          });

          window.wx.ready(function () {
              window.wx.onMenuShareTimeline({
                  title: '分好啦抽奖答题，小朋友快来玩呀', // 分享标题
                  link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx96fe7d112262e6d4&redirect_uri=http%3A%2F%2Fwww.fhlts.com%2Fshare%2Fredirection&response_type=code&scope=snsapi_base&state=1&connect_redirect=1#wechat_redirect', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                  imgUrl: 'http://lianyun.mandokg.com/upload/', // 分享图标
                  success: function () {
                  },
                  cancel: function () {
                    alert('123');
                  }
              });

              window.wx.onMenuShareAppMessage({
                  title: '分好啦抽奖答题，小朋友快来玩呀', // 分享标题
                  desc: '分好啦抽奖答题，小朋友快来玩呀', // 分享描述
                  link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx96fe7d112262e6d4&redirect_uri=http%3A%2F%2Fwww.fhlts.com%2Fshare%2Fredirection&response_type=code&scope=snsapi_base&state=1&connect_redirect=1#wechat_redirect', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                  imgUrl: 'http://lianyun.mandokg.com/upload/', // 分享图标
                  type: 'link', // 分享类型,music、video或link，不填默认为link
                  dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                  success: function () {
                  },
                  cancel: function () {
                    alert('123');
                  }
              });
          })

          window.wx.error(function(res){
              // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
              console.log(res);
          });
      }
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
