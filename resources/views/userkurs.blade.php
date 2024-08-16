@extends('layots.main')
@section('title', 'Мои курсы')
@section('header','Мои курсы')
      
<!-- ######################## Section ######################## -->
@section('main')
<section>
  <div class="section_main">
   
      <div class="row">
      
          <section class="eight columns">         
            @foreach ($arr as $row)    
                 <article class="blog_post">
          
                 <div class="three columns">
                 <a href="{{route('kurs1', ['id'=>($row->id)])}}" class="th"><img src="{{ asset('images')}}/{{ $row->image }}" alt="desc" /></a>
                 </div>
                 <div class="nine columns">
                 <a href="{{route('kurs1', ['id'=>($row->id)])}}"><h4>{{$row->name}}</h4></a>
                 <p>Цена: {{$row->price}} руб</p>
                 <p> Участников: {{$row->count}}</p>
                 <p> Старт: {{$row->begin}}</p>
                 <p>
                    @if($date<=$row['begin'])
                    <form method="POST" action="{{route('userleave', ['id_k'=>($row->id)])}}">
                        <input type="hidden" name="data" value="{{$row['id']}}">
                        <p><button type="submit" value="{{$row['id']}}">Отписаться от курса</button>
                         {{ csrf_field() }}
                         </form>   
                    @endif
                 </p>
              </div>
          </article> 
          @endforeach       
        </section>
        
        
          
      
         
          
      </div>
    </div>
</section>
@endsection