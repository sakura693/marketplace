<form class="purchase-form" action="/mypage" method="post">
        @csrf
        <div class="purchase-content__inner">
            <div class="purchase-content item-content">
                <div class="image-inner">
                    <img class="image" src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                </div>
                <div class="item-detail">
                    <p class="item-name">{{ $item->name }}</p>                   
                    <p class="item-price"><span class="yen-mark">￥</span>{{ $item->price }}</p>

                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                </div>
            </div>

            <div class="purchase-content">
                <p class="purchase-content__label">支払い方法</p>
                <div class="purchase-content__main">
                    <div class="select-box-wrapper">
                        <!--livewireを適用⇩(wire:model="selectedPaymentMethod")-->
                        <select class="select-box" name="payment_method" wire:model="selectedPaymentMethod">
                            <option disabled selected>選択してください</option>
                            @foreach($payment_methods as $payment_method)
                                <option value="{{ $payment_method->id }}" {{ old('payment_method_id')==$payment_method->id ? 'selected' : ''}}>{{ $payment_method->payment_method }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form__error">
                    <p class="purchase-form__error-message">
                        @error('payment_method')
                        {{ $message }}
                        @enderror
                    </p>
                </div>
            </div>

            <div class="purchase-content">
                <div class="purchase-content__upper">
                    <p class="address__label">配送先</p>
                    
                    <!--仮⇩-->
                    <a class="edit-addres__link" href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <div class="purchase-content__main">
                    <p class="postal-code">〒 {{ $user->postal_code }}</p>
                    <p class="address">{{ $user->address }}{{ $user->building }}</p>
                </div>
            </div>
        </div>

        <div class="check-inner">
            <div class="check-content__price">
                <p class="check-content__label">商品代金</p>
                <p class="check-content__input">￥{{ $item->price }}</p>
            </div>
            <div class="check-content__payment">
                <p class="check-content__label">支払い方法</p>
        
                <!--支払方法が選択された場合に表示-->
                <p class="check-content__input"> 
                    @if ($selectedPaymentMethod){{ $payment_methods->firstwhere('id', $selectedPaymentMethod)->payment_method }}
                    @else
                        未選択
                    @endif
                </p>
            </div>
            <input class="purchase-btn btn" type="submit" value="購入する">
        </div>
    </form>