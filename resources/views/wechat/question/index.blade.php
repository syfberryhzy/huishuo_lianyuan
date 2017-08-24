@extends('layouts.wechat')

@section('content')
  <div class="question-bg">
    <img src="/images/nan.png" class="question-img nan">
    <img src="/images/nv.png" class="question-img nv">
    <img src="/images/pangbai.png" class="question-img pangbai">
  </div>

  <div class="question-tips">
    <p class="question-title">请认真完成测试题。准备好了吗？</p>
    <a href="{{ route('answer',  array('question' => 1)) }}" class="question-start">
      <img src="/images/start.gif">
    </a>
    <a class="question-rule" href="{{ route('rules', array('question' => 1)) }}">活动规则>></a>
    <div class="bottom_logo">
      <img src="/images/btm_logo.png">
    </div>
  </div>
@endsection
