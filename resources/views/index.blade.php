@extends('layots.main')
@section('title', 'Мастер-классы')
@section('header','Мастер-классы')
@php
$counter = 0;
@endphp
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
              
                @foreach($zap as $zaps)
                    @if($zaps['id_u']==$id && $zaps['id_k']==$row['id'])
                        <p style="color:MediumSeaGreen;">Вы уже записаны на этот курс</p>
                        @php
                        $counter = 1;
                        @endphp
                        @break  
                        @endif 
                        @endforeach
                
                    @if($row['status']==0&&$counter == 0)
                        <p style="color:MediumSeaGreen;">Запись открыта</p>
                        <form method="POST" action="{{route('zapis')}}">
                        <input type="hidden" name="data" value="{{$row['id']}}">
                        <p><button type="submit" value="{{$row['id']}}">Записаться</button>
                         {{ csrf_field() }}
                         </form>    
                    @elseif($row['status']==1 &&$counter == 0)
                    <p style="color:red;">Запись прошла</p>
                    @elseif($row['status']==2 &&$counter == 0)
                    <p style="color:red;">Нет мест</p>
                     @endif 
                     
           
               
               


              </div>
          </article> 
          @endforeach       
        </section>
        
        
          
      
         
          
      </div>
    </div>
</section>
@endsection
@section('sec2')
<div class="section_dark">
   <div class="row"> 
   
   <h2></h2>
   
       <div class="two columns">
       <img src="{{asset('images/thumb1.jpg')}}" alt="desc" />
       </div>
       
       <div class="two columns">
       <img src="{{asset('images/thumb2.jpg')}}" alt="desc" />
       </div>
       
       <div class="two columns">
       <img src="{{asset('images/thumb3.jpg')}}" alt="desc" />
       </div>
       
       <div class="two columns">
       <img src="{{asset('images/thumb4.jpg')}}" alt="desc" />
       </div>
       
       <div class="two columns">
       <img src="{{asset('images/thumb5.jpg')}}" alt="desc" />
       </div>
       
       <div class="two columns">
       <img src="{{asset('images/thumb6.jpg')}}" alt="desc" />
       </div>

   
   </div>
   </div>

<!-- ######################## Section ######################## -->
@endsection