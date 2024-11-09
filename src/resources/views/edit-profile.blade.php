@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit-profile.css') }}">
@endsection

@section('link')
<form class="search__form" action="">
    @csrf
    <input class="search__form-input" type="text" placeholder="なにをお探しですか？">
</form>
<div class="header-btn">
    <form action="/logout" method="post">
        @csrf
        <input class="logout-btn" type="submit" value="ログアウト">
    </form>
    <a class="mypage-btn" href="">マイページ</a>
    <a class="sell-btn" href="/sell">出品</a>
</div>
@endsection

@section('content')
<div class="content-form">
    <h2 class="content-heading">プロフィール設定</h2>

    <form class="profile-form" action="" method="post">
        @csrf
        <!--⇩画像を挿入する場所作成-->
        <div class="form__group img-group">
            <div class="img-content">
                <div class="profile-img"></div>
                <input class="img-btn" type="file" name="image" id="img" value="{{ old('image') }}">
                <label class="img-label" for="img">画像を選択する</label>
            </div>
            <div class="form__error">
                <!--エラーの記述-->
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">ユーザー名</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="name" value="{{ old('name') }}">
            </div>
            <div class="form__error">
                <!--エラーの記述-->
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">郵便番号</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="postal_code" value="{{ old('postal_code') }}">
            </div>
            <div class="form__error">
                <!--エラーの記述-->
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">住所</div>
            <div class="form__group-content">
                <input class="text-input"  type="text" name="address" value="{{ old('address') }}">
            </div>
            <div class="form__error">
                <!--エラーの記述-->
            </div>
        </div>

        <!--保留-->
        <div class="form__group">
            <div class="form__group-title">建物</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="building" value="{{ old('building') }}">
                </input>
            <div class="form__error">
                <!--エラーの記述-->
            </div>
        </div>

        <div class="form__button">
            <!--仮（inputでボタン作る？？）-->
            <button class="profile-btn btn">更新する</button>
        </div>
    </form>
</div>


@endsection