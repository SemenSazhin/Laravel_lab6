@extends('layots.main')
@section('title', $data['name'])
@section('header',$data['name'])
<!-- ######################## Section ######################## -->

@section('main')
<section class="section_light">
      <div class="row">
      
      <p> <img src="{{ asset('images')}}/{{ $data['image'] }}" alt="desc" width=200 text-align=left>
        <p>Цель: {{ $data['description'] }}
        <p>Цена: {{ $data['price'] }} руб
        <p>Старт: {{ $data['begin'] }}
        <p>Количество участников: {{ $data['count'] }}
        
       @if($zap==1)
       <p style="color:MediumSeaGreen;">Вы уже записаны на этот курс</p>
               @elseif($data['status']==0)
                <p style="color:MediumSeaGreen;">Запись открыта</p>
                <form method="POST" action="{{route('zapis')}}">
                <input type="hidden" name="data" value="{{$data['id']}}">
          <p><button type="submit" value="{{$data['id']}}">Записаться</button>
          {{ csrf_field() }}
          </form>    
                @elseif($data['status']==1)
                <p style="color:red;">Запись прошла</p>
                @else
                <p style="color:red;">Нет мест</p>
                @endif 
               
                            
      </div>
</section>
 
@endsection

