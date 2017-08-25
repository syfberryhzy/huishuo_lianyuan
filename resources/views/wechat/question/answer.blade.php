@extends('layouts.wechat')

@section('content')
<div class="answer-title">
    <p class="answer-title_word1">{{ $question['question'] }}</p>
    {{-- <p class="answer-title_word2">可回收垃圾？</p> --}}
</div>
<div class="answer-choose">
    <answerchoose answers="{{ json_encode($answers) }}" question="{{ $question['id'] }}"></answerchoose>
</div>
@endsection
