@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

<!--header部分のリンク-->
@section('link')
<form class="search__form" action="/search" method="get">
    <input class="search__form-input" type="text" name="keyword" placeholder="なにをお探しですか？">
</form>
<div class="header-btn">
    <form action="/logout" method="post">
        @csrf
        <input class="logout-btn" type="submit" value="ログアウト">
    </form>

    <!--認証済みのユーザのみマイページにアクセス可能で、それ以外はクリックしても飛べない-->
    <a class="mypage-btn" href="/mypage">マイページ</a>
    <a class="sell-btn" href="/sell">出品</a>
    
</div>
@endsection



@section('content')
<div class="content-form">
    <div class="item-form__btn-inner">
        <!--aタグのがいいの？-->
        <div class="label-inner">
            <a class="recomend-label" href="/">おすすめ</a>
            <a class="mylist-label" href="/?page=mylist">マイリスト</a>
        </div>
    </div>
    
    <div class="item-card__inner">
        <div class="item-form" > 
            <div class="item-cards">
                @foreach($items as $item) <!--コントローラで定義する-->
                <a class="item-card__inner" href="/item/{{$item->id}}">
                    <div class="item-card">
                        <div class="item-card__img-wrapper">
                            <img class="item-card__img" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="item-label">
                            <p class="item-name">{{ $item->name }}</p>
                            
                            <!--もしitemのsoldカラムがtrueならsold、違うなら空-->
                            <p class="sold-label">{{ $item->sold ? 'sold' : '' }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


