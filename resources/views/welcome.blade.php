@extends('layouts.app')

@section('content')
    <div class="center jumbotron">
        <div class="text-center">
            <h1>ようこそTasklistへ</h1>
            {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get','新規登録',[],['class' => 'btn btn-lg btn-primary']) !!}
        </div>
    </div>
@endsection