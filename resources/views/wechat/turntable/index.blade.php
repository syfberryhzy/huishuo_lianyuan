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
          {{--
          <li style="margin-top: 0px; ">
              <span>刘二明</span>
              <span>2017-08-16</span>
              <span>获得二等奖</span>
          </li>
          <li style="margin-top: 0px; ">
              <span>刘三明</span>
              <span>2017-08-15</span>
              <span>获得三等奖</span>
          </li>
          <li style="margin-top: 0px; ">
              <span>刘四明</span>
              <span>2017-08-14</span>
              <span>获得一等奖</span>
          </li> --}}
      </ul>
</div>
@endsection
