@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
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
    <p>ああああ</p>
    @endif

    <div class="item-form">
        <!--aタグのがいいの？-->
        <div class="label-inner">
            <div class="recomend-label">おすすめ</div>
            <div class="mylist-label">マイリスト</div>
        </div>
    </div>
    
    <div class="item-card__inner">
        <form class="item-form" action="" enctype="multipart/form-data">  <!--enctype必要？-->
            @csrf
            <div class="item-cards">
                @foreach($items as $item) <!--コントローラで定義する-->
                <!--仮のパス-->
                <a class="item-card__inner" href="/item/:{{$item->id}}">
                    <div class="item-card">
                        <div class="item-card__img-wrapper">
                            <img class="item-card__img" src="{{ asset('$item->image') }}" alt="{{ $item->name }}">
                        </div>
                        <div class="item-label">
                            <p class="item-name">{{ $item->name }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </form>
    </div>
</div>
@endsection


