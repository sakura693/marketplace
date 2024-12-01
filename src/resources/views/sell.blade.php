@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('link')
<div class="search__form">
    @csrf
    <input class="search__form-input" type="text" placeholder="なにをお探しですか？">
</div>
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
    <h2 class="content-heading">商品の出品</h2>

    <form class="sell-form" action="/" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__group img-group">
            <div class="form__group-title">商品画像</div>
            <div class="form__group-content img-content">
                <input class="text-input img-btn" type="file" name="image" id="image">
                <label class="img-label" for="image">画像を選択する</label>
            </div>
            <div class="form__error">
                <p class="sell-form__error-message">
                    @error('image')
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
                            <input class="category-btn" type="checkbox" name="category[]" id="category_{{ $category->id }}" value="{{ $category->id }}" {{ old('category') && in_array($category->id, old('category')) ? 'checked' : '' }}>
                            <label class="category-name" for="category_{{ $category->id }}">{{ $category->category}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('category')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
            
            <div class="form__group">
                <div class="form__group-title">商品の状態</div>
                <div class="form__group-content select-content">
                    <div class="select-box-wrapper">
                        <select class="select-box" name="status_id">
                            <option disabled selected>選択してください</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : ''}}>{{ $status->status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('status_id')
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
                    <textarea class="text-input textarea-box"  name="description" rows="5">{{ old('description') }}</textarea>
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('description')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">販売価格</div>
                <div class="form__group-content">
                    <input class="text-input" type="text" name="price" value="{{ old('price') }}" placeholder="￥">
                </div>
                <div class="form__error">
                    <p class="sell-form__error-message">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>
        </div>

        <div class="form__button">
            <input class="sell-btn btn" type="submit" value="出品する">
        </div>
    </form>
</div>

@endsection