<template>
<div>
    <div class="answer-choose_main answer-t1" v-for="(item, key) in lists">
    <p class="answer-choose_word" v-on:click="changeAnswer(item[0], key)">
        <span class="answer-choose_wd1">{{ item[0] }}.</span>
        <span class="answer-choose_wd2">{{ item[1] }}</span>
        <template v-if="item[2] !== ''">
            <img class="answer-choose_dui" v-if="item[2] === true" src="/images/answer/dui.png">
            <img class="answer-choose_cuo" v-else src="/images/answer/cuo.png">
        </template>
    </p>
    </div>
</div>
</template>
<script>
    export default {
        props: ['answers', 'question'],
        data() {
            return {
                lists: JSON.parse(this.answers),
                result: '',
                ifClick: false
            }
        },
        mounted() {
            console.log(JSON.parse(this.answers))
        },

        methods: {
            changeAnswer(item, key) {
                if (this.ifClick === false) {
                    this.ifClick = true;
                    let that = this;
                    //that.result = false;
                    this.$http.post(`/wechat/question/${this.question}/answer`, {
                        answer: item
                    })
                    .then(response => {
                        var lists = JSON.parse(that.answers);
                        lists[key][2] = response.data.judge;
                        that.lists = lists;
                        console.log(response);
                        if (response.data.question) {
                            window.location.href = `/wechat/question/${response.data.question}/answer`;
                        } else if (response.data.test) {
                            window.location.href = `/wechat/test/${response.data.test}/answer`;
                        }
                    })
                    .catch(response => {
                        that.ifClick = false;
                    })
                }
            }
        }
    }
</script>
<style>
    .answer-choose{
        margin-top:10px;
    }
    .answer-choose .answer-choose_main{
        font-size:22px;
        font-family:"庞门正道标题体";
        background: url(/images/answer/btn.png) no-repeat center;
        background-size:cover;
        width: 7.86666667rem;
        height: 1.57333333rem;
        margin-left:auto;
        margin-right: auto;
        margin-top: 0.15rem;
    }
    .answer-choose_word{
        margin-left:0.53333333rem;
        line-height: 1.57333333rem;
        height: 1.57333333rem;
    }
    .answer-choose_wd1{
        color:#dcbf08;
    }
    .answer-choose_wd2{
        color:#96af4e;
    }
    .answer-choose_dui,.answer-choose_cuo{
    }
    .answer-choose_dui{
        height: 0.48rem;
        width: 0.48rem;
        margin-top: 0.48rem;
        float: right;
        margin-right: 7px;
    }
    .answer-choose_cuo{
        height: 0.48rem;
        width: 0.48rem;
        margin-top: 0.48rem;
        float: right;
        margin-right: 7px;
    }
</style>
