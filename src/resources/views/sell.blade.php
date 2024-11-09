@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
    <h2 class="content-heading">商品の出品</h2>

    <form class="sell-form" action="" method="">
        @csrf
        <div class="form__group img-group">
            <div class="form__group-title">商品画像</div>
            <div class="form__group-content img-content">
                <input class="text-input img-btn" type="file" name="image" id="img" value="{{ old('image') }}">
                <label class="img-label" for="img">画像を選択する</label>
            </div>
            <div class="form__error">
                <p class="sell-form__error-message">
                    @error('')
                    {{ $message }}
                    @enderror
                </p>
            </div>
        </div>

        <div class="content-group">
            <div class="content-group__heading">
                <div class="content-group__heading-text">商品の詳細</div>
            </div>
            <div class="form__group">
                <div class="form__group-title">カテゴリー</div>
                <div class="form__group-content">
                    <div class="category-content">
                        @foreach($categories as $category)
                        <div class="categoryies">
                            <input class="category-btn" type="radio" name="category" id="category_{{ $category->id }}" value="{{ $category->id }}">
                            <label class="category-name" for="category_{{ $category->id }}">{{ $category->category}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            
            <div class="form__group">
                <div class="form__group-title">商品の状態</div>
                <div class="form__group-content select-content">
                    <div class="select-box-wrapper">
                        <select class="select-box">
                            <option disabled selected>選択してください</option>
                            <!--statusesテーブルから１つずつ取り出して出力-->
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id')==$status->id ? 'selected' : ''}}>{{ $status->status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
        </div>



        <div class="content-group">
            <div class="content-group__heading">
                <div class="content-group__heading-text">商品名と説明</div>
            </div>
            
            <div class="form__group">
                <div class="form__group-title">商品名</div>
                <div class="form__group-content">
                    <input class="text-input" type="text" name="name" value="{{ old('name') }}">
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">商品の説明</div>
                <div class="form__group-content">
                    <textarea class="text-input textarea-box"  name="description" rows="5" value="{{ old('description') }}"></textarea>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">販売価格</div>
                <div class="form__group-content">
                    <input class="text-input"  type="text" name="selling-price" value="{{ old('selling-price') }}" placeholder="￥">
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
        </div>

        <div class="form__button">
            <!--仮（inputでボタン作る？？）-->
            <in class="sell-btn btn">出品する</in>
        </div>
    </form>
</div>

@endsection