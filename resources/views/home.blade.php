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

               @include('layouts.search-box-partial')

               <br>

       </div>
   </div>


@endsection

