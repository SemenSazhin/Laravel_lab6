
<!DOCTYPE html><html c
lass="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Вход</title>
  <link rel="stylesheet" href="{{ asset('css/foundation.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="row">
<h1>Вход</h1>
<div class="row">
<form method="POST" action="{{route('login')}}" > 
<p>Логин <input name="login" placeholder="shadowdancer123" > @error('login')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Пароль <input name="password" placeholder="123" > @error('password')   <span style="color:red"> {{ $message }} @enderror </span>
<p><button type="submit">Войти</button>
{{ csrf_field() }}
</form>
<form method="POST" action="{{route('reg')}}">
<p><button type="submit">Зарегистрироваться</button>
{{ csrf_field() }}
<p style="color:Tomato;">{{$err}}</p>
<p style="color:MediumSeaGreen;">{{$access}}</p>
</form>
</div>
</body>
</html>