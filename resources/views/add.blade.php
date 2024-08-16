@extends('layots.main')
@section('title', 'Добавить')
@section('header','Добавить курс')
<!-- ######################## Section ######################## -->

@section('main')
<div class="row">
<h1>Добавление записи</h1>
<div class="row">
<form method="POST" action="{{route('addform')}}">
<p>Название <input name="name" placeholder="Крутой курс" >
<p>Описание <input name="description"  placeholder="login" > 
<p><select name="code">
<option value="Английский">Английский</option>
<option value="Французский">Французский</option>
<option value="Немецкий">Немецкий</option>
<option value="Китайский">Китайский</option>
</select>
<p>Количество человек <input name="count" input type="numeric" placeholder="23" > 
<p>Цена <input name="price" input type="numeric" placeholder="4545" > 
<p>Изображение <input name="image" input type="file" placeholder="Выбрать изображение" > 
<p>Начало курса <input name="begin" input type="date" placeholder="Дата" > 
<p><button type="submit">Добавить</button>
{{ csrf_field() }}
</form>
@endsection