@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <h3>{{ Auth::user()->name }}</h3>
        {{-- 投稿一覧 --}}
        @include('tasks.index')
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to th Tasklist</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get','Sign up now!',[],['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection