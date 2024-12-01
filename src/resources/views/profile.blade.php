@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
    <div class="profile-contnt">
        <div class="profile-content__inner">
            @if ($user->image !== null)
                <div class="profile-img__wrapper">
                    <img class="profile-img" src="{{ asset( $user->image )}}" alt="{{ $user->name }}">
                </div>
            @else        
                <div class="non-profile-img"></div>
            @endif

            <div class="text">
                <p class="user-name">{{ $user->name }}</p>
                <div class="profile-label__container">
                    <a class="profile-label" href="/mypage/profile">プロフィールを編集</a>
                </div>
            </div>
        </div>
    </div>

    <div class="item-form__label">
        <div class="label-inner">
            <a class="sell-label" href="/mypage?tab=sell">出品した商品</a>
            <a class="buy-label" href="/mypage?tab=buy">購入した商品</a>
        </div>
    </div>
    
    <div class="item-card__inner">
        <div class="item-form">
            <div class="item-cards">
                @foreach($items as $item) 
                <a class="item-card__inner" href="/item/{{$item->id}}">
                    <div class="item-card">
                        <div class="item-card__img-wrapper">
                            <img class="item-card__img" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <div class="item-label">
                            <p class="item-name">{{ $item->name }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection


