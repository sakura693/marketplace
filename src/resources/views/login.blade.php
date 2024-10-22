@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="content-form">
    <h2 class="content-heading">ログイン</h2>

    <form class="register-form" action="" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">ユーザー名</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="name" value="{{ old('name') }}">
            </div>
            <div class="form__error">
                <p class="register-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">メールアドレス</div>
            <div class="form__group-content">
                <input class="text-input" type="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="form__error">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__button">
            <!--仮（inputでボタン作る？？）-->
            <button class="login-btn btn">ログインする</button>
            <a  class="back-btn" href="/register">会員登録はこちら</a>
        </div>
    </form>
</div>


@endsection