@extends('layouts.app')
@section('title', 'Home')
    @section('styles')
        <style>
            .search-box{
                margin-top: 100px;
            }

        </style>
    @endsection
@section('content')
   <div class="row">
       <div class="col-md-12 main-content">

           @if (session('status'))
               <div class="alert alert-success">
                   <h5>{{ session('status') }}</h5>
               </div>
           @endif

           {{--<h4>WELCOME TO THE INVENTORY CONTROL SYSTEM</h4>--}}
           {{--<br>--}}
           {{--<h4 class="time"><script type="text/javascript">--}}
                   {{--document.write ('<p>TIME : <span id="date-time">', new Date().toLocaleString(), '<\/span>.<\/p>')--}}
                   {{--if (document.getElementById) onload = function () {--}}
                       {{--setInterval ("document.getElementById ('date-time').firstChild.data = new Date().toLocaleString()", 50)--}}
                   {{--}--}}
               {{--</script></h4>--}}
           {{--<hr>--}}



           <form action="" method="get">
               <div class="form-group search-box">
                   <div class="input-group custom_font">

                       <input type="text" name="s" id="search_auto_complete" placeholder="Search Item " class="form-control search_input_height" autofocus
                       style="font-size: large"
                       />
                       <span class="input-group-addon" ><button class="btn"><span class="glyphicon glyphicon-search"></span></button></span>

                   </div>
               </div>
           </form>


               <br>

       </div>
   </div>


@endsection

