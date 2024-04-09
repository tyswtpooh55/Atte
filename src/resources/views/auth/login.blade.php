@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href=" {{asset('css/auth/login.css')}} ">
@endsection

@section('content')
    <div class="login__content auth__content">
        <h2 class="register__heading content__heading">ログイン</h2>
        <div class="login-form auth-form">
            <form class="login-form__form auth-form__form" action="/login" method="POST">
                @csrf
                <input class="login-form__input auth-form__input" type="email" name="email" id="email" placeholder="メールアドレス" />
                <p class="auth-form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </p>
                <input class="login-form__input auth-form__input" type="password" name="password" id="password" placeholder="パスワード" />
                <p class="auth-form__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </p>
                <input class="login-form__btn auth-form__btn" type="submit" value="ログイン" />
            </form>
        </div>
        <div class="login__footing auth__footing">
            <p class="login__footing--txt auth__footing--txt">
                アカウントをお持ちでない方はこちらから
            </p>
            <a class="login__footing--link auth__footing--link" href="/register">会員登録</a>
        </div>
    </div>
@endsection