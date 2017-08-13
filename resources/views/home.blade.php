@extends('layouts.app')
@section('title', 'Home')
@section('content')
   <div class="row">
       <div class="col-md-12">

           <h4>WELCOME TO THE INVENTORY CONTROL SYSTEM</h4>
           <br>
           <h4 class="time"><script type="text/javascript">
                   document.write ('<p>TIME : <span id="date-time">', new Date().toLocaleString(), '<\/span>.<\/p>')
                   if (document.getElementById) onload = function () {
                       setInterval ("document.getElementById ('date-time').firstChild.data = new Date().toLocaleString()", 50)
                   }
               </script></h4>
           <hr>
           <form>
               <div class="form-group">

                   <div class="input-group custom_font">

                       <input type="text" name="search_text" id="search_text" placeholder="Enter Item Name, Category,  Description" class="form-control search_input_height" autofocus/>
                       <span class="input-group-addon" >SEARCH</span>

                   </div>
               </div>
           </form>
           <br>

       </div>
   </div>


@endsection
