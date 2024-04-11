@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href=" {{ asset('css/auth/verify-email.css') }} ">
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('メールアドレスの認証') }}</div>
        <div class="card-body">
            <p>{{ __('確認用リンクを登録されたメールアドレスに送信しました。') }}</p>
            <p>{{ __('メールにあるリンクから認証を完了してください。') }}</p>
            <p>{{ __('メールが届かない、またはメールの有効期限が切れた場合、') }}</p>
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                    {{ __('こちら') }}</button><span class="email-resend">をクリックして再度メールを送信してくさい。</span>
            </form>
        </div>
    </div>
</div>
@endsection