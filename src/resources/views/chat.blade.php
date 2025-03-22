@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<div class="container">
    <div class="trade-container">
        <div class="sidebar-container">
            <p class="sidebar__text">その他の取引</p>

            <div class="other-tems__container">
                <a class="other-items">商品名</a>
                <a class="other-items">商品名</a>
                <a class="other-items">商品名</a>
            </div>
        </div>

        <div class="content-container">
            <div class="content-top">
                <div class="inner-content__top">
                    @if ($user->image !== null)
                        <img class="profile-img" src="{{ asset($partner->image) }}" alt="{{$partner->name}}">
                    @else        
                        <div class="non-profile-img"></div>
                    @endif

                    <p class="content-top__title">「{{$partner->name}}」さんとの取引画面</p>

                    <!--取引完了ボタン-->
                    <div class="btn-container">
                        <a class="complete-btn" href="#modal">取引を完了する</a>
                    </div>
                </div>
            </div>

            <div class="content-middle">
                <div class="inner-content__middle">
                    <img class="image" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                    <div class="text-content">
                        <p class="item-name">{{$item->name}}</p>
                        <p class="item-price">{{$item->price}}円</p>
                    </div>
                </div>
            </div>

            <div class="content-bottom">
                <div class="chat-history">
                    @foreach($chats as $chat)
                        @if ($chat->user_id === $user->id)
                            <div class="right-content">
                                <div class="right-content__container">
                                    <div class="user-info">
                                        <div class="user-info__container">
                                            <p class="user-name name-right">{{$user->name}}</p>

                                            @if ($user->image !== null)
                                                <img class="profile-img" src="{{ asset($user->image) }}" alt="{{$user->name}}">
                                            @else        
                                                <div class="non-img"></div>
                                            @endif
                                        </div>
                                    </div>
                    
                                    <div class="input-space space__right">
                                        @if(request('edit') == $chat->id)
                                            <form class="message-edit-form" action="/mypage/chat/{{$chat->id}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="message" value="{{ old('message', $chat->message) }}">
                                                <button class="store-btn">保存</button>
                                                <a href="/mypage/chat/{{ $item->id }}">キャンセル</a>
                                            </form>
                                        @else
                                            <div class="input-space">{{ $chat->message }}</div>
                                        @endif
                                </div>    
                                    
                                    @if($chat->image !== null)
                                        <img class="message-image message-img__right" src="{{ asset($chat->image) }}" alt="image">
                                    @endif

                                    <div class="btn-container">
                                        <div class="btn__inner-container">
                                            <form action="/mypage/chat/{{ $item->id }}" method="get">
                                                <input type="hidden" name="edit" value="{{ $chat->id }}">
                                                <button class="edit-btn" type="submit">編集</button>
                                            </form>

                                            <form action="/mypage/chat/{{$chat->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button  class="delete-btn"type="submit">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="left-content">
                                <div class="left-content__container">
                                    <div class="user-info">
                                        @if ($user->image !== null)
                                            <img class="profile-img" src="{{ asset($partner->image) }}" alt="{{$partner->name}}">
                                        @else        
                                            <div class="non-img"></div>
                                        @endif
                                            <p class="user-name">{{$partner->name}}</p>
                                            @if($chat->image !== null)
                                                <img class="message-image" src="{{ asset($chat->image) }}" alt="image">
                                            @endif
                                    </div>

                                    <div class="input-space">{{ $chat->message }}</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="form__error">
                    <p class="message-form__error-message">
                        @error('message')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <div class="form__error">
                    <p class="message-form__error-message">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
                <form class="message-form" action="/mypage/chat/{{$item->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="message-container">
                        <div class="message-container__inner">
                            <input class="message-input" type="text" name="message" placeholder="取引メッセージを記入してください" value="{{ old('message') }}">
                            <input class="img-upload" type="file" name="image" id="image">
                            <label class="img-label" for="image">画像を追加</label>

                            <button class="message-send-btn">
                                <i class="fa-regular fa-paper-plane fa-2xl plane-icon" style="color: #bcbcbd;"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-container" id="modal">
                <form class="modal-container__inner" action="/mypage/chat/{{$item->id}}/rate" method="POST">
                    @csrf
                    <p class="modal-title">取引が完了しました。</p>
                    
                    <div class="modal-content" >
                        <div class="modal-content__middle">
                            <p class="modal-text">今回の取引相手はどうでしたか？</p>
                            <div class="modal-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                    <label class="star-label" for="star{{ $i }}">&#9733;</label>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="send-btn__container">
                        <button class="send-btn" type="submit">送信する</button>
                    </div>    
                </form>
            </div>

        </div>
    </div>
</div>
@endsection