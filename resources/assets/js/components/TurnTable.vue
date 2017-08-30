<template>
    <div>
        <div class="KePublic_begin">
            <div class="banner">
              <div class="turnplate" style="background-image:url(/images/turnplate-bg_2.png);background-size:100% 100%;">
                  <canvas class="item" id="wheelcanvas" width="516" height="516"></canvas>
                  <img id="tupBtn" class="pointer" src="/images/turnplate-pointer_2.png" v-on:click="rotate"/>
              </div>
            </div>
        </div>
        <div class="dialog" v-if="dialog === true" v-on:click="closeDialog">
            <div class="zj-main" v-if="ifWinning === true">
                <div class="txzl">
                    <h3>HI 亲！人品爆发！</h3>
                    <h2>恭喜抽中<br /><span id="jiangpin">{{ prize.title }}</span></h2>
                    <p>请填写资料兑换奖品：</p>
                    <label>姓名：<input type="text" name="username" v-model="username"/></label>
                    <label>电话：<input type="text" name="userphone" v-model="userphone"/></label>
                    <h4><sub>*</sub>未提交个人资料将视为放弃领取此次奖品</h4>
                    <div class="info_tj" v-on:click="submitPrize">提交领奖</div>
                </div>
            </div>

            <div class="zj-main" v-if="ifWinning === false">
                <div class="txzl">
                    <h3>谢谢参与！</h3>
                    <p>不要气馁，每周答题还可以抽奖哦。</p>
                </div>
            </div>

            <div class="zj-main" v-if="ifConvert === true">
                <div class="txzl">
                    <h3>感谢参与！</h3>
                    <p>这周已经抽过奖品了，下周答题还可以抽奖哦。</p>
                </div>
            </div>

            <div class="zj-main" v-if="prizeSubmit === true">
            	<div class="txzl">
                	<h3>恭喜您提交成功</h3>
                    <p>提交后24小时内工作人员会与您联系</p>
                    <img src="/images/fenxiang.png" width="30%" height="" style="padding-bottom:10px" v-on:click="shareFriend">
                </div>
            </div>

            <div class="zj-main" v-if="share.show === true">
                <img class="zj-main share" src="/images/mengban.png" width="100%" height="100%" v-on:click="closeDialog"/>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['question', 'restaraunts', 'colors'],
        data() {
            return {
                turnplate : {
                    restaraunts: JSON.parse(this.restaraunts),
                    colors: JSON.parse(this.colors),
            		//fontcolors:[],			//大转盘奖品区块对应文字颜色
            		outsideRadius:222,			//大转盘外圆的半径
            		textRadius:165,				//大转盘奖品位置距离圆心的距离
            		insideRadius:65,			//大转盘内圆的半径
            		startAngle: - Math.PI / 2,				//开始角度
            		bRotate:false
                },
                dialog: false,
                ifWinning: '',
                ifConvert: '',
                username: '',
                userphone: '',
                prize: '',
                lottery: '',
                prizeSubmit: false,
                share: {
                    show: false,
                    title: '分好啦抽奖答题，小朋友快来玩呀',
                    desc: '分好啦抽奖答题，小朋友快来玩呀',
                    link: 'http://lianyun.mandokg.com/wechat/activity/1/redirect',
                    imgUrl: ''
                }
            }
        },

        mounted() {
            this.drawRouletteWheel()
        },

        methods: {
            shareFriend() {
                this.shareInit();
                this.prizeSubmit = false;
                this.share.show = true;
            },
            shareInit() {
                let that = this;
                wx.onMenuShareTimeline({
                    title: that.share.title, // 分享标题
                    link: that.share.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.share.imgUrl, // 分享图标
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        that.share.show = false;
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        that.share.show = false;
                    }
                });

                wx.onMenuShareAppMessage({
                    title: that.share.title, // 分享标题
                    desc: that.share.desc, // 分享描述
                    link: that.share.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: that.share.imgUrl, // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        that.share.show = false;
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        that.share.show = false;
                    }
                });
            },
            submitPrize() {
                var that = this;
                this.$http.post(`/wechat/lottery/${this.lottery}`, {
                    username: that.username,
                    phone: that.userphone
                })
                .then(response => {
                    if (response.data.status == 1) {
                        this.ifWinning = '';
                        this.prizeSubmit = true;
                    }

                })
                .catch(response => {

                })
            },
            closeDialog(e) {
                var $class = $(e.target).attr('class');
                if ($class === 'zj-main') {
                    this.dialog = false;
                }
            },
            rotate() {
                if (this.turnplate.bRotate === false) {
                    let that = this;
                    // this.share.show = false;
                    this.turnplate.bRotate = true;
                    this.$http.post(`/wechat/activity/${this.question}/turntable`, {

                    })
                    .then(response => {
                        let prize = response.data.prize;
                        this.prize = prize;
                        this.lottery = response.data.lottery;
        				this.share = {
        				    show: false,
        				    title: response.data.prize.header,
        				    desc: response.data.prize.des,
        				    imgUrl: 'http://lianyun.mandokg.com/upload/' + response.data.prize.image,
                            link: 'http://lianyun.mandokg.com/wechat/activity/1/redirect'
        				}
                        this.shareInit();
            			if (response.data.rotate === 0) {
            			    this.dialog = true;
            			    this.ifConvert = true;
            			    this.turnplate.bRotate = false;
            			    return false;
            			}
                        $("#wheelcanvas").rotate({
                            angle: 0,
                            animateTo: parseInt(response.data.rotate),
                            duration: 6000,
                            callback: function () {
                                if (prize.is_lottery == 1) {
                                    that.dialog = true;
                                    that.ifWinning = true;
                                } else {
                                    that.dialog = true;
                                    that.ifWinning = false;
                                }
                                that.turnplate.bRotate = false;
                            }
                        });
                    })
                    .catch(response => {
                        alert('网络异常，请重新尝试');
                        that.turnplate.bRotate = false;
                    });
                }
            },
            drawRouletteWheel() {
                var canvas = document.getElementById("wheelcanvas");
                  if (canvas.getContext) {
                	  //根据奖品个数计算圆周角度
                	  var arc = Math.PI / (this.turnplate.restaraunts.length / 2);
                	  var ctx = canvas.getContext("2d");
                	  //在给定矩形内清空一个矩形
                	  ctx.clearRect(0,0,516,516);
                	  //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
                	  ctx.strokeStyle = "#FFBE04";
                	  //font 属性设置或返回画布上文本内容的当前字体属性
                	  ctx.font = 'bold 22px Microsoft YaHei';
                	  for(var i = 0; i < this.turnplate.restaraunts.length; i++) {
                		  var angle = this.turnplate.startAngle + i * arc;
                		  ctx.fillStyle = this.turnplate.colors[i];
                		  ctx.beginPath();
                		  //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                		  ctx.arc(258, 258, this.turnplate.outsideRadius, angle, angle + arc, false);
                		  ctx.arc(258, 258, this.turnplate.insideRadius, angle + arc, angle, true);
                		  ctx.stroke();
                		  ctx.fill();
                		  //锁画布(为了保存之前的画布状态)
                		  ctx.save();

                		  //----绘制奖品开始----
                		  ctx.fillStyle = "#CB0030";
                		  //ctx.fillStyle = this.turnplate.fontcolors[i];
                		  var text = this.turnplate.restaraunts[i];
                		  var line_height = 30;
                		  //translate方法重新映射画布上的 (0,0) 位置
                		  ctx.translate(258 + Math.cos(angle + arc / 2) * this.turnplate.textRadius, 258 + Math.sin(angle + arc / 2) * this.turnplate.textRadius);

                		  //rotate方法旋转当前的绘图
                		  ctx.rotate(angle + arc / 2 + Math.PI / 2);

                		  /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
                		  if(text.indexOf("\n")>0){//换行
                			  var texts = text.split("\n");
                			  for(var j = 0; j<texts.length; j++){
                				  ctx.font = j == 0?'bold 22px Microsoft YaHei':'bold 22px Microsoft YaHei';
                				  //ctx.fillStyle = j == 0?'#FFFFFF':'#FFFFFF';
                				  if(j == 0){
                					  //ctx.fillText(texts[j]+"M", -ctx.measureText(texts[j]+"M").width / 2, j * line_height);
                					  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                				  }else{
                					  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                				  }
                			  }
                		  }else if(text.indexOf("\n") == -1 && text.length>6){//奖品名称长度超过一定范围
                			  text = text.substring(0,6)+"||"+text.substring(6);
                			  var texts = text.split("||");
                			  for(var j = 0; j<texts.length; j++){
                				  ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                			  }
                		  }else{

                			  //在画布上绘制填色的文本。文本的默认颜色是黑色
                			  //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
                			  ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                		  }

                		  //把当前画布返回（调整）到上一个save()状态之前
                		  ctx.restore();
                          //return false;
                		  //----绘制奖品结束----
                	  }
                  }
            }
        }
    }
</script>
<style>
/*****抽奖页面****/
#app {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
}
.ml-main {
  min-width: 10rem;
  width: 10rem;
  height: 100vh;
  background: url(/images/bg.jpg) no-repeat;
  background-size: 100% 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.ml-main .keTitle{
  width: 45vw;
  height: auto;
  margin: 0 auto;
}
.ml-main .keTitle .title{width:100%;height:auto;margin:15% auto;}
.ml-main .keTitle .xian{width:100%;height:auto;}
.ml-main .kePublic{width:8rem;height:auto;}
.KePublic_begin{max-width:640px; margin:0 auto;margin-top:20vh}
/* 大转盘样式 */
.banner{display:block;width:95%;margin-left:auto;margin-right:auto;}
.banner .turnplate{display:block;width:100%;position:relative;}
.banner .turnplate canvas.item{width:100%;}
.banner .turnplate #tupBtn{position:absolute;width:27.5%;height:33.5%;left:36%;top:30.5%;border:0;background:none;}
.banner .turnplate img{width:100%;height:auto;}
/*******中奖页面*******/
.zj-main {
    width: 10rem;
    height: 100vh;
    background-color: rgba(0,0,0,0.7);
    background-size: 100% 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
.dialog {
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    overflow: hidden;
    *zoom: 1;
    z-index: 111;
    top: 0;
    left: 0;
}
.txzl{
    width:90%;
    /*height: 6rem;*/
    background: url(/images/zj_1.png) center;
    background-size: 100% 100%;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}
.txzl h3{
    font-size: 18px;
    font-weight: bold;
    width: 60%;
    height: auto;
    margin: 0 auto;
    margin-top: 10px;
    color: #e32d2c;
    text-align: center;
}
.txzl h2{font-size:16px;font-weight:bold;width:100%;height:auto;margin:0 auto;color:#e32d2c;text-align:center;}
.txzl p{
    font-size: 14px;
    width: 90%;
    height: auto;
    margin: 1% auto 0 auto;
    color: #232323;
    text-align: center;
    padding-bottom: 10px;
}
.txzl label{width:90%;height:auto;margin:3% auto 0 auto;font-size:16px;color:#232323;display:block;text-align:center;}
.txzl label input{
    height: auto;
    font-size: 12px;
    border: none;
    height: 0.8rem;
    width: 5rem;
}
.txzl h4{font-size:12px;font-weight:bold;width:100%;height:auto;margin:3% auto 0 auto;color:#e32d2c;text-align:center;}
.txzl .info_tj{
    width: 3rem;
    height: 1rem;
    color: #ffffff;
    text-align: center;
    background: #ad0004;
    border-radius: 10px;
    margin-bottom: 0.5rem;
    line-height: 1rem;
}
.share {
    background-color: rgba(0,0,0,0.1);
}
</style>
