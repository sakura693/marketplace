@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="content-form">
    <h2 class="content-heading">会員登録</h2>

    <form class="register-form" action="/register" method="post">
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

        <div class="form__group">
            <div class="form__group-title">パスワード</div>
            <div class="form__group-content">
                <input class="text-input"  type="password" name="password" value="{{ old('password') }}">
            </div>
            <div class="form__error">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <!--保留-->
        <div class="form__group">
            <div class="form__group-title">確認用パスワード</div>
            <div class="form__group-content">
                <input class="text-input" type="" name="password_confirmation" value="{{ old('password_confirmation') }}">
                </input>
            <div class="form__error">
                <p class="register-form__error-message">
                    @error('password_confirmation')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__button">
            <!--仮（inputでボタン作る？？）-->
            <button class="register-btn btn">登録する</button>
            <a  class="back-btn" href="/login">ログインはこちら</a>
        </div>
    </form>
</div>


@endsection