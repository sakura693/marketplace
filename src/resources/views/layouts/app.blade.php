<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--メディアクエリを適用させるためのコード⇩-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">

    <!-- LivewireStylesを挿入 -->
    @yield('livewire-styles') 
    
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <!--headerにロゴを挿入-->
            <image class="header__image" src="{{ asset('header-img/logo.svg')}}" alt="COACHTECH">
            @yield('link') <!--ヘッダー部分のボタン用-->
        </header>
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- LivewireScriptsを挿入 -->
    @yield('livewire-scripts')
</body>

</html>