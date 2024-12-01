@extends('layouts.app')

@section('livewire-styles')
    @livewireStyles
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
    @livewire('purchase-details', [
        'item' => $item,
        'user' => $user,
        'payment_methods' => $payment_methods
        ])
</div>
@endsection


@section('livewire-scripts')
    @livewireScripts
@endsection