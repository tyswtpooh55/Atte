@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{  asset('css/user.css') }}">
@endsection

@section('header')
    <div class="header__link">
        <form action="/" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="home">ホーム</button>
        </form>
        <form action="/attendance" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="date">日付一覧</button>
        </form>
        <form action="/user" method="GET">
            @csrf
            <button class="header__link--btn" type="submit" name="user">ユーザー一覧</button>
        </form>
        <form action="/logout" method="POST">
            @csrf
            <button class="header__link--btn" type="submit" name="logout">ログアウト</button>
        </form>
    </div>
@endsection

@section('content')
    <div class="atte-box">
        @foreach ($users as $user)
        <p><a class="atte__link" href="{{ route('user.attendance', ['id' => $user->id]) }}">{{ $user->name }}</a></p>
        @endforeach
    </div>
@endsection