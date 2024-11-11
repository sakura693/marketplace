@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

<!--header部分のリンク-->
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
    <!--ログイン後の出力画面（仮）-->
    @if (Auth::check())
    <p>ログインできてるよ</p>
    @endif

    <form class="purchase-form" action="" method="">
        <div class="purchase-content__inner">
            <div class="purchase-content item-content">
                <div class="image-inner">
                    <div class="image">商品画像</div>
                </div>
                <div class="item-detail">
                    <p class="item-name">商品名</p>
                    <p class="item-price"><span class="yen-mark">￥</span>47,000</p>
                </div>
            </div>

            <div class="purchase-content">
                <p class="purchase-content__label">支払い方法</p>
                <div class="purchase-content__main">
                    <div class="select-box-wrapper">
                        <select class="select-box">
                            <option disabled selected>選択してください</option>
                            @foreach($payment_methods as $payment_method)
                            <option value="{{ $payment_method->id }}" {{ old('payment_method_id')==$payment_method->id ? 'selected' : ''}}>{{ $payment_method->payment_method }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="purchase-content">
                <div class="purchase-content__upper">
                    <p class="address__label">配送先</p>
                    <a class="edit-addres__link" href="/mypage/profile">変更する</a>
                </div>
                <div class="purchase-content__main">
                    <p class="address">ここに住所が入ります</p>
                </div>
            </div>
        </div>

        <div class="check-inner">
            <div class="check-content__price">
                <p class="check-content__label">商品代金</p>
                <p class="check-content__input">￥47,000</p>
            </div>
            <div class="check-content__payment">
                <p class="check-content__label">支払い方法</p>
                <p class="check-content__input">コンビニ払い</p>
            </div>
            <input class="purchase-btn btn" type="submit" value="購入する">
        </div>
    </form>
</div>
@endsection