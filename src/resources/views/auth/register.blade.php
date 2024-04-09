@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register__content auth__content">
        <h2 class="login__heading content__heading">会員登録</h2>
        <div class="register-form auth-form">
            <form class="registe-form__form auth-form__form" action="/register" method="POST">
                @csrf
                <input class="register-form__input auth-form__input" type="text" name="name" id="name" placeholder="名前" />
                <p class="auth-form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
                <input class="register-form__input auth-form__input" type="email" name="email" id="email" placeholder="メールアドレス" />
                <p class="auth-form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </p>
                <input class="register-form__input auth-form__input" type="password" name="password" id="password" placeholder="パスワード" />
                <p class="auth-form__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </p>
                <input class="register-form__input auth-form__input" type="password" name="password_confirmation" id="password_confirmation" placeholder="確認用パスワード" />
                <p class="auth-form__error">
                    @error('confirm_password')
                        {{ $message }}
                    @enderror
                </p>
                <input class="register-form__btn auth-form__btn" type="submit" value="会員登録" />
            </form>
        </div>
        <div class="register__footing auth__footing">
            <p class="register__footing--txt auth__footing--txt">
                アカウントをお持ちの方はこちらから
            </p>
            <a class="register__footing--link auth__footing--link" href="/login">ログイン</a>
        </div>
    </div>
@endsection