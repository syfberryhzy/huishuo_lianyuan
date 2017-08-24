@extends('layouts.wechat')

@section('content')
<div class="answer-title">
    <p class="answer-title_word1">{{ $question['question'] }}</p>
    {{-- <p class="answer-title_word2">可回收垃圾？</p> --}}
</div>
<div class="answer-choose">
  @foreach ($answers as $value)
    <answerchoose answer="{{ json_encode($value) }}" question="{{ $question['id'] }}"></answerchoose>
  @endforeach
</div>
@endsection
