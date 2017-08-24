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
</div>
@endsection
