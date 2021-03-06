@extends('layouts.app')
@section('title', 'Item Assignment')
@section('styles')
    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 0;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">




                <h1 class="page-header" align="center"> <strong>ITEM REQUEST DETAILS</strong> </h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                DETAILS OF THE ITEM THAT WAS REQUESTED
                            </div>
                            <div class="panel-body">
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
                                            <td> MODEL NUMBER</td> <td>{{ $item->model_number }}</td>
                                        </tr>


                                        <tr>
                                            <td>ITEM LOCATION</td>
                                            <td>{{ $item->location }}</td>
                                        </tr>


                                        </tbody>
                                    </table>

                                    @if(isset($accessoriesRequested))

                                        <ul class="list-group">
                                            <li class="list-group-item list-group-item-heading list-group-item-info">
                                                <span class="badge">{{  count( $accessoriesRequested) }}</span>
                                                Accessories Requested
                                            </li>
                                            @foreach($accessoriesRequested as $itemAccessory)
                                                <li class="list-group-item">
                                                    {{ $itemAccessory->name }}
                                                    <div class="badge">{{ isset($itemAccessory->item_id)? \App\Utility\Utils::findItemById($itemAccessory->item_id)->name : 'Standalone'  }}</div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @endif
                            </div> <!--table responsive-->

                        </div>
                        <div class="panel-footer">


                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">




                        <div class="response-notification"></div>


                        <div class="panel panel-info">

                            <div class="panel-heading">
                                REQUESTER INFO
                            </div>
                            <div class="panel-body">
                               <ul class="list-group">
                                    <li class="list-group-item">Name: {{ $user->getName() }} <br></li>
                                    <li class="list-group-item">Phone: {{ $user->phone_number }} </li>
                                    <li class="list-group-item">E-mail : {{ $user->email }}</li>
                                </ul>

                            </div>
                            <div class="panel-footer">
                                @if( !$itemRequest->is_accepted && !$itemRequest->is_rejected)

                                    <ul class="list-group">
                                        <li class="list-group-item"> Request Sent On :
                                            <strong>
                                                {{ \App\Utility\Utils::getReadableDateTime($itemRequest->created_at)}}
                                            </strong>
                                        </li>

                                        <li class="list-group-item">  Pick-Up time :
                                            <strong>
                                                {{ App\Utility\Utils::getReadableDateTime($itemRequest->pickup_time)}}

                                            </strong>
                                        </li>

                                    </ul>

                                    <button type="button"
                                            class="btn btn-success"
                                            id="buttonApproved"
                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing ..."
                                    >
                                        <i class="fa fa-key"> </i>
                                        APPROVE THE REQUEST
                                    </button>


                                        <a
                                        class="btn btn-warning pull-right"
                                        href="{{ route('request.reject', $itemRequest->id) }}"
                                        data-toggle="tooltip" title="The request will be revoked and the related item and accessories will be made available again"
                                        >
                                            <i class="fa fa-arrow-circle-down"></i>
                                            REJECT THE REQUEST
                                        </a>


                                    <div class="help-block" style="padding: 10px;">
                                    </div>
                                @elseif($itemRequest->is_rejected)

                                <h4 class="label label-warning">This request was rejected</h4>

                                @elseif($itemRequest->is_accepted)
                                    <ul class="list-group">
                                        <li class="list-group-item"> Approved By :
                                            <strong>
                                                @php echo \App\User::all()->where('id', $itemRequest->approved_by)->first()->getName(); @endphp
                                            </strong>
                                        </li>

                                        <li class="list-group-item">  Approved On :
                                            <strong>
                                               {{ App\Utility\Utils::getReadableDateTime($itemRequest->approved_on)}}
                                            </strong>
                                        </li>

                                    </ul>

                                    <ul class="list-group">
                                        <li class="list-group-item"> Request Sent On :
                                            <strong>
                                                {{ \App\Utility\Utils::getReadableDateTime($itemRequest->created_at)}}
                                            </strong>
                                        </li>

                                        <li class="list-group-item">  Pick-Up time :
                                            <strong>
                                                {{ App\Utility\Utils::getReadableDateTime($itemRequest->pickup_time)}}

                                            </strong>
                                        </li>

                                    </ul>

                                    @if($itemRequest->pickup_time < \Carbon\Carbon::now()->addDay(1)) && $item->status === \App\Utility\ItemStatus::$ITEM_RESERVED && $itemRequest->is_accepted)

                                        <div class="panel panel-warning">
                                            <div class="panel-heading">USER HAS DELAYED TO PICK UP THE ITME</div>
                                            <div class="panel-body">
                                                The user <strong>{{ $user->getName() }}</strong>  made a request to reserve the item <strong>{{ $item->name }}</strong>.
                                                Request which was accepted.He Planned to pick it up on {{ App\Utility\Utils::getReadableDateTime($itemRequest->pickup_time)}}
                                                But He has not yet come to take it.

                                            </div>
                                            <div class="panel-footer">
                                                <a class="btn btn-warning" href="{{ route('item.release', $item->slug) }}"
                                                   data-toggle="tooltip" title=""
                                                >
                                                    <i class="fa fa-unlock"></i>
                                                    Release The Item
                                                </a>
                                            </div>
                                        </div>


                                    @endif



                                @endif

                            </div>
                        </div>
                    </div>

                </div>

            </div>




        </div>
        </div>

@endsection
@section('scripts')
       <script>
        $(document).ready(function () {

            $('[data-toggle="tooltip"]').tooltip();

            var $buttonApproved = $('#buttonApproved');

            $buttonApproved.on('click', function(e) {

                $buttonApproved.button('loading');

                $.ajax({
                    method: "GET",
                    timeout: 8000,
                    url: '{{ route('request-response-accepted', $itemRequest->id) }}'

                })
                    .done(function( response ) {
                        $('.response-notification').replaceWith('<h5 class="alert alert-success response-notification"  style="margin-top: 20px"> '+ response.message +'</h5>')
//                        console.log(response.message)
                    })
                    .fail(function (e) {

                        console.log(e);
//                        $('.on-error').replaceWith('<h5 class="alert alert-warning" style="margin-top: 20px" > Something went wrong when trying to send the notification to the user. Try again later.</h5>');
                        if(e.responseJSON){
                            $('.response-notification').replaceWith(
                                '<h4 class="alert alert-warning response-notification" style="margin-top: 10px" >'+e.responseJSON.message+'</h4>'
                            )
                        }

                        if(e.statusText === "timeout"){
                            $('.response-notification').replaceWith(
                                '<h4     class="alert alert-warning response-notification" style="margin-top: 10px" > The process took long than expected. Try again later.</h4>'
                            )
                        }

                    })
                    .always(function () {
                        $buttonApproved.button('reset');
                    });
            });

        });

    </script>
@endsection

