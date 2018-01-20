@extends('layouts.app')
@section('title', 'Items')
@section('styles')


    <style>
        .item-element{
            background: #fff;
            padding: 20px;
            margin-bottom: 10px;
        }
        .item-search-form{
            margin-top: 50px;
            margin-bottom: 30px;
        }

        footer{
            margin-top: 0px;
        }

        .btn-request{
            width: 100%;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="container main-content">
        <div class="row">

            <div class="col-md-12">

                @if (session('error-status'))
                    <div class="alert alert-info" style="margin-top: 10px">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                @if (session('success-status'))
                    <div class="alert alert-info" style="margin-top: 10px">
                        <h5>{{ session('success-status') }}</h5>
                    </div>
                @endif

                @include('layouts.search-box-partial')
                <div class="col-md-8">
                    @foreach($items as $item)

                        <div class="row  item-element">


                            <div class="col-md-4">


                            <img src="{{ isset($item->photo_url)? asset('storage/'.substr($item->photo_url,7)) : asset('assets/images/No_image_available.png') }}"
                                 class="img-thumbnail img-listing">




                            </div>

                            <div class="col-md-8">
                                <h3><a href="{{ route('items.show', $item->slug) }}">{{ $item->name }}</a></h3> <h4>Item Serial Number : {{ $item->serial_number }}</h4>
                                <h5>
                                    @if(Auth::check())
                                        @if(\App\Utility\RoleUtils::isSystemPersonnel())
                                            Price : <strong class="label label-success">{{ "USD ".number_format( $item->price,2,'.',',') }}</strong>
                                        @endif
                                    @endif

                                Condition : <strong class="label label-info"> {{ $item->itemCondition->name }} </strong>
                                </h5>
                                <h5>Category : <a href="{{ route('item-categories.showCategoryItems', $item->itemCategory->slug) }}">{{ $item->itemCategory->name }}</a> </h5>
                                <p class="">
                                    {{ substr($item->description,0,400) }} ...
                                </p>
                                @if($item->is_available())
                                    <a class="btn btn-primary " href="{{ route("items.show", $item->slug) }}">Read more ... </a>

                                    <a href="{{ route('request.index', $item->slug) }}" class="btn btn-primary">REQUEST THIS ITEM</a>
                                @else
                                    <a class="btn btn-default btn-request disabled">SORRY NOT AVAILABLE</a>
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
                                        @php
                                            $itemCategoryCount = \App\Item::all()->where('category_id', $item_category->id)->count();
                                        @endphp
                                        <a href="{{ route('item-categories.showCategoryItems', $item_category->slug) }}" class="list-group-item">
                                            {{ ($item_category->name)}}<span class="badge badge-info">{{ $itemCategoryCount }}</span>
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


