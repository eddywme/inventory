@extends('layouts.app')
@section('title', 'Users')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .item-element{
            background: #fff;
            padding: 20px;
            margin-bottom: 10px;
        }
        .item-search-form{
            margin-top: 50px;
        }
        img{
            height:200px;
            width:200px;
        }
        footer{
            margin-top: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="container main-content">



        <div class="row">

            <div class="col-md-12">
                <form action="" method="get" class="item-search-form">
                    <div class="form-group search-box">
                        <div class="input-group custom_font">

                            <input type="text" name="s" id="search_auto_complete" placeholder="Search Item " class="form-control search_input_height" autofocus
                                   style="font-size: large"
                            />
                            <span class="input-group-addon" ><button class="btn"><span class="glyphicon glyphicon-search"></span></button></span>

                        </div>
                    </div>
                </form>
                <div class="col-md-8">
                    @foreach($items as $item)
                        <div class="row  item-element">


                            <div class="col-md-4">

                                <img src="{{ isset($item->photo_url)? url('storage/app/'.$item->photo_url) : asset('assets/images/No_image_available.png') }}" class="img-thumbnail">

                            </div>

                            <div class="col-md-8">
                                <h3><a href="{{ route('items.show', $item->slug) }}">{{ $item->name }}</a></h3> <h4>Item Serial Number : {{ $item->serial_number }}</h4>
                                <h5>Price : <strong>{{ "USD ".number_format( $item->price,2,'.',',') }}</strong>     Condition : {{ $item->itemCondition->name }}</h5>
                                <p>
                                    {{ substr($item->description,0,400) }} ...
                                </p>
                                @if($item->is_available)
                                    <a class="btn btn-default">REQUEST</a>
                                    @else
                                    <a class="btn btn-default disabled">SORRY NOT AVAILABLE</a>
                                @endif

                            </div>
                        </div>

                    @endforeach

                        {{ $items->links() }}
                </div>

                <div class="col-md-4">

                    <div class="well">
                        <h4>ITEM CATEGORIES</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="list-group">
                                    @foreach($item_categories as $item_category )
                                        <a href="" class="list-group-item">
                                            {{ ($item_category->name)}}<span class="badge badge-info"></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>





        </div>




        </div>

@endsection
@section('scripts')

@endsection

