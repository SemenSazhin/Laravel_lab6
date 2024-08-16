@extends('layots.main')
@if($admin==1)
@section('title', 'Админ-панель')
@section('header','Админ-панель')
@php
$counter = 0;
$del=0;
@endphp
<!-- ######################## Section ######################## -->
@section('main')

<div class="section_main">
   
      <div class="row">
      
          <section class="eight columns">         
            @foreach ($arr as $row)
            @php
            $del=0;
            @endphp    
                 <article class="blog_post">
          
                 <div class="three columns">
                 <a href="{{route('kurs1', ['id'=>($row->id)])}}" class="th"><img src="{{ asset('images')}}/{{ $row->image }}" alt="desc" /></a>
                 </div>
                 <div class="nine columns">
                 <a href="{{route('kurs1', ['id'=>($row->id)])}}"><h4>{{$row->name}}</h4></a>
                 <p>Цена: {{$row->price}} руб</p>
                 <p> Участников: {{$row->count}}</p>
                 <p> Старт: {{$row->begin}}</p>
              <p>Участники
                @foreach($zap as $zaps)
                    @if($zaps['id_k']==$row['id'])
                    <ul>
                    <li>{{$zaps['FIO']}} </li>
                    @php
                    $del=1;
                    @endphp
                    </ul>
                    @endif
                    @endforeach

                    @if($row['status']==0&&$counter == 0)
                        <p style="color:MediumSeaGreen;">Запись открыта</p>  
                    @elseif($row['status']==1 &&$counter == 0)
                    <p style="color:red;">Запись прошла</p>
                    @elseif($row['status']==2 &&$counter == 0)
                    <p style="color:red;">Нет мест</p>
                     @endif 
                  
                     @if($del==0)
                     
                        <div > <a href="/del/{{$row->id}}" >Удалить</a></div>
                     
                     @endif
           
               
               


              </div>
          </article> 
          @endforeach       
        </section>

        <section class="four columns">
            <H3>  &nbsp; </H3>
             <div class="panel">
              <h3>Админ-панель</h3>

            <ul class="accordion">
              <li class="active">
                <div class="title">
                   <a href="/add"><h5>Добавить курс</h5></a>
                </div>
               
              </li>
            </ul>
               
             </div>
          </section>
        
          
      
         
          
      </div>
    </div>
</section>
@else
<h1>Недостаточно прав для просмотра данной страницы</h1>
@endif
@endsection

