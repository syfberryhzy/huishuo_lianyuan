<template>
    <div class="answer-choose_main answer-t1">
    <p class="answer-choose_word" v-on:click="changeAnswer(item[0])">
        <span class="answer-choose_wd1">{{ item[0] }}.</span>
        <span class="answer-choose_wd2">{{ item[1] }}</span>
        <template v-if="result !== ''">
            <img class="answer-choose_dui" v-if="result === true" src="/images/answer/dui.png">
            <img class="answer-choose_cuo" v-else src="/images/answer/cuo.png">
        </template>
    </p>
    </div>
</template>
<script>
    export default {
        props: ['answer', 'question'],
        data() {
            return {
                item: JSON.parse(this.answer),
                result: ''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            changeAnswer(item) {
                let that = this;
                that.result = false;
                console.log(that.result);
                console.log(`/wechat/question/${this.question}/answer`);
                this.$http.post(`/wechat/question/${this.question}/answer`, {
                    answer: item
                })
                    .then(response => {
                        console.log(response)

                    });
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
