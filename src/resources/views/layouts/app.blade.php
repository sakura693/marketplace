<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('livewire-styles') 
    
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <image class="header__image" src="{{ asset('header-img/logo.svg')}}" alt="COACHTECH">
            @yield('link')
        </header>
        <div class="content">
            @yield('content')
        </div>
    </div>
    @yield('livewire-scripts')
</body>

</html>