@extends('layouts.wechat')

@section('content')
<div class="grade-main">

</div>
<div class="grade-main_content">
    <p class="grade-main_msg">您的最后得分是：{{ $count }}</p>
    <ul class="grade-main_box">
        @foreach ($answers as $key => $value)
          <li>
              <div class="grade-result">
                  <span>#{{ $value['id'] }}</span>&nbsp;&nbsp;
                  @if ($value['status'])
                    <img src="/images/dui.png">
                  @else
                    <img src="/images/cuo.png">
                  @endif
              </div>
          </li>
        @endforeach
    </ul>

    <redirect url={{ $url }}></redirect>
</div>
@if ($url === '')
<div id="time-main" v-if="show === true">
    <div class="time-main"></div>
    <div class="time_msg">
        <div class="time_msg_w1">
            <span>很遗憾</span><br>
            <span>你的分数未达到抽奖资格</span>
        </div>
    </div>
    <div class="time_btn">
        <img src="/images/index/close_1.png" v-on:click="cancelTimeShow">
    </div>
</div>
@endif

@endsection
