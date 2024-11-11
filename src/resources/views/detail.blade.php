@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
    
    <form class="item-form" action="/item/{{ $item->id }}/update" method="post" enctype="multipart/form-data">
        @csrf
        <div class="item-image">
            <div class="item-image__inner">
                <img class="image" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
            </div>
        </div>
        <div class="form__group">
            <div class="item-content__inner">
                <p class="item-content__name">{{ $item->name }}</p>
                <p class="item-content__brand">ブランド名</p>
                <p class="item-content__price"><span class="yen-mark">￥</span>{{ $item->price}}<span class="item-content__price-tax">（税込）<span></p>
                <!--星とか吹き出し追加-->
                <a class="item-btn btn" href="/purchase">購入手続きへ</a>


                <div class="item-content">
                    <p class="item-content__heading">商品説明</p>
                    <p class="item-description__content">{{ $item->description }}</p>
                </div>

                <div class="item-content">
                    <div class="item-content__heading">商品の情報</div>
                    <div class="item-category">
                        <p class="item-information__label">カテゴリー</p>
                        <p class="item-information__category">
                            @foreach($product_category as $category)
                                {{ $category->category_id }}
                            @endforeach
                        </p>
                    </div>

                    <div class="item-category">
                        <p class="item-information__label">商品の状態</p>
                        <p class="item-information__status"></p>
                    </div>
                </div>

                <div class="item-content">
                    <div class="comment__heading">コメント（）
                    </div>
                    <div class="comment-user">ユーザー</div>
                    <div class="comment-inner">
                        <p class="comment-content">こちらにコメントが入ります</p>
                    </div>
                    <div class="commeny-input">
                        <div class="comment-input__label">商品へのコメント</div>
                        <textarea class="comment-input_content" cols="50" rows="10"></textarea>
                        <input class="item-btn btn" type="submit" value="コメントを送信する">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
