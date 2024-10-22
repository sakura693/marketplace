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
    <a class="login-btn" href="">ログアウト</a>
    <a class="mypage-btn" href="">マイページ</a>
    <a class="sell-btn" href="">出品</a>
</div>
@endsection



@section('content')
@endsection