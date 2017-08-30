<template lang="html">

</template>

<script>
export default {
    props: ['jssdk', 'jsapilist'],
    data() {
        return {
            config: JSON.parse(this.jssdk),
            list: JSON.parse(this.jsapilist)
        }
    },
    mounted() {
        wx.config({
            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: this.config.appId, // 必填，公众号的唯一标识
            timestamp: this.config.timestamp, // 必填，生成签名的时间戳
            nonceStr: this.config.nonceStr, // 必填，生成签名的随机串
            signature: this.config.signature,// 必填，签名，见附录1
            jsApiList: [
                ...this.list
            ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });

        wx.ready(function(){
            wx.onMenuShareTimeline({
                title: '分好啦抽奖答题，小朋友快来玩呀', // 分享标题
                link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx96fe7d112262e6d4&redirect_uri=http%3A%2F%2Fwww.fhlts.com%2Fshare%2Fredirection&response_type=code&scope=snsapi_base&state=1&connect_redirect=1#wechat_redirect', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://lianyun.mandokg.com/upload/image/answer_bg.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });

            wx.onMenuShareAppMessage({
                title: '分好啦抽奖答题，小朋友快来玩呀', // 分享标题
                desc: '分好啦抽奖答题，小朋友快来玩呀', // 分享描述
                link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx96fe7d112262e6d4&redirect_uri=http%3A%2F%2Fwww.fhlts.com%2Fshare%2Fredirection&response_type=code&scope=snsapi_base&state=1&connect_redirect=1#wechat_redirect', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://lianyun.mandokg.com/upload/image/answer_bg.png', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });

            wx.hideMenuItems({
                menuList: [
                    'menuItem:copyUrl',
                    'menuItem:delete',
                    'menuItem:openWithQQBrowser',
                    'menuItem:openWithSafari',
                ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
            });
        })

        wx.error(function(res){
            // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            console.log(res);
        });
    }
}
</script>

<style lang="css">
</style>
