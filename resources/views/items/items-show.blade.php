@extends('layouts.app')
@section('title')
    {{ $item->name  }}
@endsection
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
        .item-search-form{
            margin: 50px;
        }
        .item-info{
            margin: 20px;
        }

        .btn-request{
            width: 100%;
            margin-top: 20px;
        }

    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">

                @include('layouts.search-box-partial')


                    <div class="row item-info">
                        <hr>
                        <div class="col-md-4">
                            <h2>{{ $item->name }}   <h4>Serial Number: {{ $item->serial_number }}</h4></h2><br>


                            <img src="{{ isset($item->photo_url)? asset('storage/'.substr($item->photo_url,7)) : asset('assets/images/No_image_available.png') }}" class="img-thumbnail item-img-show">

                            @if($item->is_available())
                                <a href="{{ route('request.index', $item->slug) }}" class="btn btn-default btn-request">REQUEST</a>
                            @else
                                <a class="btn btn-default btn-request disabled">SORRY NOT AVAILABLE</a>
                            @endif

                        </div>

                        <div class="col-md-8 "><br>
                            <div class="table-responsive" >
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ITEM PROPERTY</th><th>ITEM VALUE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> NAME</td> <td class="item_value_column">{{ $item->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> SERIAL NUMBER</td> <td class="item_value_column">{{ $item->serial_number }}</td>
                                    </tr>
                                    <tr>
                                        <td> IDENTIFIER TAG</td> <td class="item_value_column">{{ $item->identifier }}</td>
                                    </tr>
                                    <tr>
                                        <td> PRICE</td> <td class="item_value_column">{{ "USD ".number_format( $item->price,2,'.',',') }}</td>
                                    </tr>


                                    <tr>
                                        <td> TIME SPAN </td> <td class="item_value_column"> {{  $item->timeSpanObject()['hours']." hrs ".$item->timeSpanObject()['days']." days ".$item->timeSpanObject()['months']." months "
                                 .$item->timeSpanObject()['years']." years" }}</td>
                                    </tr>

                                    <tr>
                                        <td> CATEGORY</td> <td class="item_value_column">{{ $item->itemCategory->name }}</td>
                                    </tr>

                                    <tr>
                                        <td> CONDITION</td> <td class="item_value_column">{{ $item->itemCondition->name }}</td>
                                    </tr>

                                    <tr>
                                        <td> DESCRIPTION</td>
                                        <td class="item_value_column">{{ $item->description }}</td>
                                    </tr>

                                    <tr>
                                        <td> QUANTITY</td> <td class="item_value_column"> {{ $itemQ }} Remaining [{{ $item->itemCondition->name }}]</td>
                                    </tr>


                                    <tr>
                                        <td> STATUS</td> <td> {{ $item->showStatusName() }}</td>
                                    </tr>

                                    <tr>
                                        <td> MODEL NUMBER</td> <td>{{ $item->model_number }}</td>
                                    </tr>

                                    @if(\Illuminate\Support\Facades\Auth::check())

                                       @if(\App\Utility\Utils::isAdmin())

                                        <tr>
                                            <td>ITEM OWNED BY</td>
                                            <td>{{ $item->ownedBy->getName() }}</td>
                                        </tr>

                                        <tr>
                                            <td>ITEM LOCATION</td>
                                            <td>{{ $item->location }}</td>
                                        </tr>

                                        <tr>
                                            <td>RECORDED BY</td>
                                            <td>{{ $item->recordedBy->getName() }}</td>
                                        </tr>

                                        <tr>
                                            <td>ITEM DATE ACQUIRED</td>
                                            <td>{{ (date("F jS, Y ",strtotime($item->date_acquired))) }} </td>
                                        </tr>

                                       @endif

                                    @endif


                                    </tbody>
                                </table>
                            </div> <!--table responsive-->

                            @if(\Illuminate\Support\Facades\Auth::check())

                                @if(\App\Utility\Utils::isAdmin())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>


                                            @if(!$item->is_available())
                                            <th>
                                                <a href="" class="btn btn-info disabled"><strong><span class="fa fa-user"> </span>&nbsp;ASSIGN ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;

                                            </th>


                                           @else
                                            <th>
                                                <a href="{{ route('assign.index', $item->slug) }}" class="btn btn-info "><strong><span class="fa fa-user"> </span>&nbsp;ASSIGN ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;

                                            </th>


                                            @endif

                                            <th>
                                                <a href="{{ route('item-accessories.create', $item->slug) }}" class="btn btn-success"><strong><span class="fa fa-plus"> </span>&nbsp;ADD ACCESSORY</strong></a>

                                            </th>
                                            <th>
                                                <a href="{{ route('items.edit', $item->slug) }}" class="btn btn-info"><strong><span class="fa fa-edit"> </span>&nbsp;EDIT ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>


                                            @if(!$item->is_available())

                                            <th>
                                                <a href="" class="btn btn-danger disabled"><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>

                                            @else
                                            <th>
                                                <a href="" class="btn btn-danger "><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>

                                            @endif
                                        </tr>

                                        </thead>
                                    </table>
                                </div>

                                @endif

                            @endif
                        </div> <!--col - md -8-->


                    </div>


            </div>




        </div>
        </div>

@endsection
@section('scripts')
@endsection

