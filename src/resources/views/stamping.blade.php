@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/stamping.css') }}">
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
    <div class="stamping__content">
            <h2 class="stamping__heading content__heading">{{ $user->name }}さんお疲れ様です！</h2>
        <div class="stamping__box">
            @if (session('success'))
                <p>
                    {{ session('success') }}
                </p>
            @endif
            @if (session('error'))
                <p>
                    {{ session('error') }}
                </p>
            @endif
            <div class="stamping-form">
                <form class="stamping-form__form" action="/workin" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="work_in">
                    <button class="stamping-form__btn" type="submit" {{ $workInBtnStatus ? 'disabled' : '' }}>勤務開始</button>
                </form>
            </div>
            <div class="stamping-form">
                <form class="stamping-form__form" action="/workout" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="work_out">
                    <button class="stamping-form__btn" type="submit" {{ $workOutBtnStatus ? 'disabled' : '' }}>勤務終了</button>
                </form>
            </div>
        </div>
        <div class="stamping__box">
            <div class="stamping-form">
                <form class="stamping-form__form" action="/breakingin" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="breaking_in">
                    <button class="stamping-form__btn" type="submit" {{ $breakingInBtnStatus ? 'disabled' : '' }}>休憩開始</button>
                </form>
            </div>
            <div class="stamping-form">
                <form class="stamping-form__form" action="/breakingout" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="breaking_out">
                    <button class="stamping-form__btn" type="submit" {{ $breakingOutBtnStatus ? 'disabled' : '' }}>休憩終了</button>
                </form>
            </div>
        </div>
    </div>
@endsection