<!DOCTYPE html>
@if($check==1)
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>@yield('title')</title>
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="{{asset('stylesheets/foundation.min.css')}}">
       <link rel="stylesheet" href="{{asset('stylesheets/main.css')}}">
  <link rel="stylesheet" href="{{asset('stylesheets/app.css')}}">

  <script src="{{asset('javascripts/modernizr.foundation.js')}}"></script>
  
  <link rel="stylesheet" href="{{asset('fonts/ligature.css')}}">
  
  <!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Playfair+Display:400italic' rel='stylesheet' type='text/css' />

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>

<body>

<!-- ######################## Main Menu ######################## -->

<nav>

     <div class="twelve columns header_nav">
     <div class="row">
     
        <ul id="menu-header" class="nav-bar horizontal">
              <h4>Пользователь: {{$userdata[0]['FIO']}}</h4>
            @if($admin==0)
          <li><a href="/main/all">Главная</a></li> 
          @elseif($admin==1)  
          <li><a href="/admin">Главная</a></li>
          @endif
          <li><a href="/lang/Английский">Английский</a></li>
          <li><a href="/lang/Французский">Французский</a></li>
          <li><a href="/lang/Немецкий">Немецкий</a></li>
          <li><a href="/lang/Китайский">Китайский</a></li> 
          @if($admin==0)
          <li><a href="/main/active">Актуальные курсы</a></li>
          <li><a href="/main/not">Нектуальные курсы</a></li>  
          <li><a href="/mycab">Мои курсы</a></li>  
          @endif
          
           <form method="POST" action="{{route('quit')}}">
          <p><button type="submit">Выйти</button>  

          {{ csrf_field() }}
          </form>    
        </ul>
   
        
      </div>  
      
      </div>
      
</nav><!-- END main menu -->
<div >  </div> 
<!-- ######################## Header (featured posts) ######################## -->
     
<header>
<section>


        <div class="row">

        <h1>@yield('header')</h1>
</div>
             
</header>

@yield('main')

</section>
<!-- ######################## Section ######################## -->

<section>
@yield('sec2')
   
 </section>


<!-- ######################## Footer ######################## -->  
   
<footer>

   <div class="row">
   
       <div class="twelve columns footer">
           <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="twitter">Twitter</a> 
           <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="facebook">Facebook</a>
           <a href="" class="lsf-icon" style="font-size:16px; margin-right:15px" title="pinterest">Pinterest</a>
           <a href="" class="lsf-icon" style="font-size:16px" title="instagram">Instagram</a>
       </div>
       
   </div>

</footer>		  

<!-- ######################## Scripts ######################## --> 

 <!-- Included JS Files (Compressed) -->
 <script src="{{asset('javascripts/foundation.min.js')}}" type="text/javascript"></script> 
 <!-- Initialize JS Plugins -->
  <script src="{{asset('javascripts/app.js')}}" type="text/javascript"></script>
</body>
@else
<h1>Вы не зарегистрированы
@endif
</html>