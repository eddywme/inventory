@extends('layouts.app')
@section('title', 'Requested Items')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">

                @if (session('error-status'))
                    <div class="alert alert-danger" style="margin-top: 10px">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                    @if (session('success-status'))
                        <div class="alert alert-info" style="margin-top: 10px">
                            <h5>{{ session('success-status') }}</h5>
                        </div>
                    @endif

                <h1 class="page-header"> <strong>REQUESTED ITEMS</strong> </h1>


                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Item Info</th><th>Requester Info</th><th>Time Info</th><th>Details</th> <th>State</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($itemRequests as $itemRequest)
                            @if(!$itemRequest->is_rejected)
                            @php
                                $item = \App\Item::where('id', $itemRequest->item_id)->first();
                                $user = \App\User::where('id', $itemRequest->user_id)->first();


                            @endphp

                            <tr>
                                <td>
                                    Name: {{ $item->name }} <br>
                                    Serial No: {{ $item->serial_number }} <br>
                                    Category : {{ $item->itemCategory->name }} <br>
                                </td>

                                <td>
                                    Name: {{ $user->getName() }} <br>
                                    Phone: {{ $user->phone_number }} <br>
                                    E-mail : {{ $user->email }} <br>
                                </td>

                                <td>
                                    Request Sent On : {{ \App\Utility\Utils::getReadableDateTime($itemRequest->created_at)}} <br>
                                    Pick-Up time : {{ App\Utility\Utils::getReadableDateTime($itemRequest->pickup_time)}}
                                </td>

                                <td>
                                    {{--<a href="{{ route('request-response-accepted', $itemRequest->id) }}" class="btn btn-success {{  $itemRequest->is_accepted? 'disabled':'' }}">Accept</a>--}}
                                    <a  class="btn btn-primary" href="{{ route('request.show', $itemRequest->id) }}">More ...</a>
                                </td>

                                <td>

                                    @if( $itemRequest->is_accepted)
                                         <span class="label label-success">APPROVED</span>
                                        @else
                                        <span class="label label-danger">PENDING</span>
                                    @endif
                                </td>


                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>

                </div>

            </div>




        </div>
        </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.confirm.js') }}"></script>

    <script>

        $(document).ready(function () {

            $('#organizers_table').DataTable({
                "bInfo" : false,
                "language": {
                    "search": "Search Item :"
                }
            });


        });


    </script>

@endsection

