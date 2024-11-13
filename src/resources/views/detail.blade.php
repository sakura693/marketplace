@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<!--Font Awesomをインポート-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    
    <div class="item-form">
        <div class="item-image">
            <div class="item-image__inner">
                <img class="image" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
            </div>
        </div>

        <div class="item-detail">
            <form class="item-information" action="/purchase/{{ $item->id }}" method="post">
                @csrf
                <div class="item-content__inner">
                    <p class="item-content__name">{{ $item->name }}</p>
                    <p class="item-content__brand">ブランド名</p>
                    <p class="item-content__price"><span class="yen-mark">￥</span>{{ $item->price}}<span class="item-content__price-tax">（税込）<span></p>
                    
                    <div class="icon-inner">
                        <!--星アイコン-->
                        <div class="icon__star">
                            <i class="fa-regular fa-star fa-lg" style="color: #5d5b5b;"></i>

                            <!--いいね数表示-->
                            <p class="like-count"></p>
                        </div>

                        <!--吹き出しアイコン（Font Awesomより）-->
                        <div class="icon__speech-bubble">
                            <i class="fa-regular fa-comment fa-lg" style="color: #5d5b5b;"></i>

                            <!--コメント数表示-->
                            <p class="comment-count">{{ $commentCount }}</p>
                        </div>
                    </div>

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
                                @foreach($item->categories as $category)
                                    <span class="category">{{ $category->category }}</span>
                                @endforeach
                            </p>
                        </div>

                        <div class="item-category">
                            <p class="item-information__label">商品の状態</p>
                            <p class="item-information__status">
                                @foreach($item->statuses as $status)
                                {{ $status->status }}
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </form>

            <form class="item-comment" action="/item/{{ $item->id }}" method="post">
                @csrf
                <div class="item-content">
                    <div class="comment__heading">コメント（{{ $commentCount }}）
                    </div>
                    <div class="comment-user">ユーザー</div>
                    <div class="comment-inner">
                        <p class="comment-content">こちらにコメントが入ります</p>
                    </div>
                    <div class="commeny-input">
                        <div class="comment-input__label">商品へのコメント</div>
                        <textarea class="comment-input_content" name="comment" cols="50" rows="10"></textarea>
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input class="item-btn btn" type="submit" value="コメントを送信する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
