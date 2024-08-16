<!DOCTYPE html><html c
lass="no-js" lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Регистрация</title>
  <link rel="stylesheet" href="{{ asset('css/foundation.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<body>
<div class="row">
<h1>Регистрация</h1>
<div class="row">
<form method="POST" action="{{route('register')}}">
<p>ФИО <input name="FIO" value="{{ old('FIO') }}"placeholder="Ivanov Ivan" >@error('FIO')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Логин <input name="login" value="{{ old('login') }}" placeholder="login" > @error('login')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Почта <input name="email" value="{{ old('email') }}" placeholder="123@mail.ru" > @error('email')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Пароль <input name="password" value="{{ old('password') }}"placeholder="parol123" > @error('password')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Подтверждение пароля <input name="passwordrepeat" placeholder="" > @error('repeatpassword')   <span style="color:red"> {{ $message }} @enderror </span>
<p>Аватар <input name="image" input type="file" value="{{ old('image') }}" placeholder="Выбрать изображение" > @error('image')   <span style="color:red"> {{ $message }} @enderror </span>
<p><button type="submit">Зарегистрироваться</button>
{{ csrf_field() }}
</form>
</body>
</html>
