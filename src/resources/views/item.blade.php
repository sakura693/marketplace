@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('link')
<form class="search__form" action="/search" method="get">
    <input class="search__form-input" type="text" name="keyword" placeholder="なにをお探しですか？">
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
    <div class="item-form__btn-inner">
        <div class="label-inner">
            <a class="recomend-label" href="/">おすすめ</a>
            <a class="mylist-label" href="/?tab=mylist">マイリスト</a>
        </div>
    </div>
    
    <div class="item-card__inner">
        <div class="item-form" > 
            <div class="item-cards">
                @foreach($items as $item) 
                <a class="item-card__inner" href="/item/{{$item->id}}">
                    <div class="item-card">
                        <div class="item-card__img-wrapper">
                            <img class="item-card__img" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="item-label">
                            <p class="item-name">{{ $item->name }}</p>
                            
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


