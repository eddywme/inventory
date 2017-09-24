@extends('layouts.app')
@section('title')
    {{ $item->name  }}
@endsection
@section('styles')
    <link href="{{ asset('assets/css/lightbox.min.css') }}" rel="stylesheet">
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
                            <h3>{{ $item->name }} <h4>Serial Number: {{ $item->serial_number }}</h4></h3>
                            <h5>Category : <a href="{{ route('item-categories.showCategoryItems',  $item->itemCategory->slug) }}">{{ $item->itemCategory->name }}</a> </h5>



                            <a
                                    class="example-image-link"
                                    href="{{ isset($item->photo_url)? asset('storage/'.substr($item->photo_url,7)) : asset('assets/images/No_image_available.png') }}"
                                    data-lightbox="example-1">

                                <img
                                        src="{{ isset($item->photo_url)? asset('storage/'.substr($item->photo_url,7)) : asset('assets/images/No_image_available.png') }}"
                                        class="img-thumbnail item-img-show example-image" alt="{{ $item->name }}" />
                            </a>

                            @if($item->is_available())
                                <a href="{{ route('request.index', $item->slug) }}" class="btn btn-primary btn-request">
                                    <i class="fa fa-bookmark"></i>
                                    REQUEST ITEM
                                </a>
                            @else
                                <a class="btn btn-default btn-request disabled">SORRY NOT AVAILABLE</a>
                            @endif

                            @if($itemAccessories)
                                <h4>Accessories <div class="badge">{{ $itemAccessories->count() }}</div></h4>
                                @foreach($itemAccessories->chunk(3) as $itemAccessoryChunk)
                                    <div class="row">
                                        @foreach ($itemAccessoryChunk as $itemAccessory)
                                            <div class="col-md-4">

                                                <a
                                                        class="example-image-link"
                                                        href="{{ isset($itemAccessory->photo_url)? asset('storage/'.substr($itemAccessory->photo_url,7)) : asset('assets/images/No_image_available.png') }}"
                                                        data-lightbox="example-1">
                                                    <img src="{{ isset($itemAccessory->photo_url)? asset('storage/'.substr($itemAccessory->photo_url,7)) : asset('assets/images/No_image_available.png') }}" class="img-thumbnail item-accessory-sm">

                                                </a>

                                                <h6><a href="{{ route('item-accessories.show', $itemAccessory->slug) }}">{{ $itemAccessory->name }}</a> </h6>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif

                            @if(\Illuminate\Support\Facades\Auth::check())
                                @if(\App\Utility\Utils::isAdmin())
                                        @if($item->status === \App\Utility\ItemStatus::$ITEM_RESERVED)
                                            @php
                                                $itemReq = \App\ItemRequest::all()->where('item_id', $item->id)->last();
                                            @endphp

                                            @if($itemReq->is_approved)
                                                <div class="bg bg-info">This item was requested and approved to {{ \App\Utility\Utils::getUserNameFromId($itemReq->user_id) }}</div>
                                                @else
                                                <div class="bg bg-info" style="padding: 3px; font-size: 12px">This item was requested by {{ \App\Utility\Utils::getUserNameFromId($itemReq->user_id) }}.<br>
                                                The request is still pending. Which means the item cannot be assigned to the user unless the request is accepted.
                                                But also it is not available to other users who might want to borrow it.<br><br>
                                                Two options : <br>
                                                    (1) Approve the request to the user. So that it can be further assigned to the user who requested it.<br><br>
                                                    (2) Release by rejecting  the Request so that other users might able to see it.
                                                </div>

                                            @endif


                                        @endif
                                @endif
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
                                        <td width="50%"> NAME</td> <td class="item_value_column">{{ $item->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> SERIAL NUMBER</td> <td class="item_value_column">{{ $item->serial_number }}</td>
                                    </tr>
                                    <tr>
                                        <td> IDENTIFIER TAG</td> <td class="item_value_column">{{ $item->identifier }}</td>
                                    </tr>
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                    @if(\App\Utility\Utils::isAdmin())
                                    <tr>
                                        <td> PRICE</td> <td class="item_value_column">{{ "USD ".number_format( $item->price,2,'.',',') }}</td>
                                    </tr>
                                    @endif
                                    @endif


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
                                        <td class="item_value_column">{{ substr($item->description, 0, 200)  }} ... </td>
                                    </tr>

                                    <tr>
                                        <td> QUANTITY</td> <td class="item_value_column"> {{ $itemQ }} Remaining  <span class="label label-info"> {{ $item->itemCategory->name }}</span>  </td>
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


                                            @if($item->status === \App\Utility\ItemStatus::$ITEM_RESERVED)

                                                @php
                                                    $itemReq = \App\ItemRequest::all()->where('item_id', $item->id)->last();
                                                @endphp

                                                @if($itemReq->is_accepted)
                                                    <th>
                                                        <a href="{{ route('assign-to-reserved.index', [$item->slug, \App\Utility\Utils::getUserSlugFromId($itemReq->user_id)]) }}"  class="btn btn-info"><strong><span class="fa fa-user"> </span>&nbsp
                                                                ASSIGN ITEM
                                                            </strong></a>&nbsp;&nbsp;&nbsp;&nbsp;

                                                    </th>
                                                @else

                                                    <th>
                                                        <a href="{{ route('request.show', $itemReq->id) }}" class="btn btn-success"><strong>
                                                                <i class="fa fa-arrow-up"></i>&nbsp;REQUEST INFO</strong></a>

                                                    </th>

                                                    <th>
                                                        <a class="btn btn-warning" href="{{ route('item.release', $item->slug) }}">
                                                            <i class="fa fa-unlock"></i>
                                                            REJECT REQUEST
                                                        </a>
                                                    </th>

                                                @endif




                                                <th>
                                                    <a href="{{ route('items.edit', $item->slug) }}" class="btn btn-info disabled"><strong><span class="fa fa-edit"> </span>&nbsp;EDIT ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>

                                                <th>
                                                    <a href="" class="btn btn-danger disabled"><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>



                                            @elseif($item->status === \App\Utility\ItemStatus::$ITEM_TAKEN)

                                                <th>
                                                    <a href="" class="btn btn-info disabled"><strong><span class="fa fa-user"> </span>&nbsp
                                                            ASSIGN ITEM
                                                    </strong></a>&nbsp;&nbsp;&nbsp;&nbsp;

                                                </th>
                                                <th>
                                                    <a href="{{ route('item-accessories.create', $item->slug) }}" class="btn btn-success disabled"><strong><span class="fa fa-plus"> </span>&nbsp;ADD ACCESSORY</strong></a>

                                                </th>

                                                <th>
                                                    <a href="{{ route('items.edit', $item->slug) }}" class="btn btn-info disabled"><strong><span class="fa fa-edit"> </span>&nbsp;EDIT ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>

                                                <th>
                                                    <a href="" class="btn btn-danger disabled"><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>


                                            @elseif($item->status === \App\Utility\ItemStatus::$ITEM_AVAILABLE)

                                                <th>
                                                    <a href="{{ route('assign.index', $item->slug) }}" class="btn btn-info "><strong><span class="fa fa-user"> </span>&nbsp;ASSIGN ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;

                                                </th>


                                                <th>
                                                    <a href="{{ route('item-accessories.create', $item->slug) }}" class="btn btn-success"><strong><span class="fa fa-plus"> </span>&nbsp;ADD ACCESSORY</strong></a>

                                                </th>
                                                <th>
                                                    <a href="{{ route('items.edit', $item->slug) }}" class="btn btn-info"><strong><span class="fa fa-edit"> </span>&nbsp;EDIT ITEM</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>

                                                <th>
                                                    {{--<a href="{{ route('items.destroy', $item->slug) }}" class="btn btn-danger "><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;--}}
                                                    <form  action="{{ route('items.destroy', $item->slug) }}" method="POST">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        {{ csrf_field() }}
                                                        <button class="btn btn-danger"
                                                                data-toggle="confirm"
                                                                data-title="Item deletion"
                                                                data-message="Do you really want to delete the Item? <br>
                                                 Once the Item is deleted all its data are deleted and the action cannot be reverted back."
                                                                data-type="danger">
                                                            <span class="fa fa-trash"></span>
                                                            REMOVE
                                                        </button>
                                                    </form>
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
    <script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.confirm.js') }}"></script>
@endsection

