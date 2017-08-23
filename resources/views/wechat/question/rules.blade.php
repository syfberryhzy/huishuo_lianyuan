@extends('layouts.wechat')

@section('content')
  <div class="rules-main">
    <img class="rules-word_bg" src="/images/rules/content_bg.png">
    <div class="rules-main_content">
        <p class="rules-main_title">活动规则</p>
         <span class="rules-main_word">
           {!! $content !!}
        </span>
    </div>
    <img src="/images/rules/button.png" class="rules_btn" onclick="history.go()">
  </div>
@endsection
