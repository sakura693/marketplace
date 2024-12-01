@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
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
    <a class="mypage-btn" href="/mypage">マイページ</a>
    <a class="sell-btn" href="/sell">出品</a>
</div>
@endsection

@section('content')
<div class="content-form">
    <h2 class="content-heading">住所の変更</h2>

    <form class="address-form" action="/purchase/address/{{$item->id}}/update" method="post">
        @csrf
        @method('PATCH')
        <div class="form__group">
            <div class="form__group-title">郵便番号</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="postal_code" value="{{ old('postal_code') }}">
            </div>
            <div class="form__error">
                <p class="address-form__error-message">
                    @error('postal_code')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">住所</div>
            <div class="form__group-content">
                <input class="text-input" type="text" name="address" value="{{ old('address') }}">
            </div>
            <div class="form__error">
                <p class="address-form__error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">建物名</div>
            <div class="form__group-content">
                <input class="text-input"  type="text" name="building" value="{{ old('building') }}">
            </div>
            <div class="form__error">
                <p class="address-form__error-message">
                    @error('building')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="form__button">
            <input class="address-btn btn" type="submit" value="登録する">
        </div>
    </form>
</div>
@endsection