@extends('layouts.wechat')

@section('content')
<div class="ml-main" id="ml-main">
      <div class="kePublic">
          <!--转盘效果开始-->
          <turntable question="{{ $question }}" restaraunts="{{ json_encode($restaraunts) }}" colors="{{ json_encode($colors) }}"></turntable>
          <!--转盘效果结束-->
          <div class="clear"></div>
      </div>
      <a href="{{ route('award', array('activity' => 1)) }}" class="zj_record">我的中奖记录>></a>
      <ul class="line">
        @foreach ($logs as $key => $value)
          <li style="margin-top: 0px; ">
              <span>{{ $value->user->name }}</span>
              <span>{{ \Carbon\Carbon::parse($value->cteated_at)->toDateString() }}</span>
              <span>{{ $value->award->title }}</span>
          </li>
        @endforeach
      </ul>
</div>
<wechat jssdk={{ json_encode($jssdk) }} jsapilist="{{ json_encode($jsApiList) }}"></wechat>
@endsection
