@extends('layouts.wechat')

@section('content')
  <div class="question-bg">
      <img src="/images/limg.png" class="question-img nan">
      <img src="/images/rimg.png" class="question-img nv">
      <img src="/images/pangbai.png" class="question-img pangbai">
  </div>

  <div class="question-tips">
    @if ($state == 1)
      <p class="question-title">请认真完成测试题。准备好了吗？</p>
      <a href="{{ route('answer', array('activity' => $activity['id'], 'question' => $now[0])) }}" class="question-start">
          <img src="/images/start.gif">
      </a>
    @endif

      <a class="question-rule" href="{{ route('rules', array('activity' => $activity['id'])) }}">活动规则>></a>
      <div class="bottom_logo">
        <img src="/images/btm_logo.png">
      </div>
  </div>
  @if ($state == 0)
  <div id="time-main" v-if="show === true">
      <div class="time-main"></div>
      <div class="time_msg">
          <div class="time_msg_w1">
              <span>{!! $message[0] !!}</span><br>
              <span>{{ $message[1] }}</span>
          </div>
      </div>
      <div class="time_btn">
          <img src="/images/index/close_1.png" v-on:click="cancelTimeShow">
      </div>
  </div>
  @endif
@endsection
