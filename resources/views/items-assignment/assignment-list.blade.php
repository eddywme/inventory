@extends('layouts.app')
@section('title', 'Assigned Items')
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

                @if (session('success-status'))
                    <div class="alert alert-info" style="margin-top: 10px">
                        <h5>{{ session('success-status') }}</h5>
                    </div>
                @endif

                    @if (session('error-status'))
                        <div class="alert alert-danger" style="margin-top: 10px">
                            <h5>{{ session('error-status') }}</h5>
                        </div>
                    @endif

                <h1 class="page-header"> <strong>ASSIGNED ITEMS</strong> </h1>


                <div class="table-responsive">

                <table class="table table-striped" id="assigned_items_table">
                    <thead>
                    <tr>
                        <th>Item Info</th><th>Assigned To</th><th>Time Info</th><th>Assigned By</th> <th>State</th> <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($itemAssignments as $itemAssignment)
                            @php
                                $item = \App\Item::where('id', $itemAssignment->item_id)->first();
                                $user = \App\User::where('id', $itemAssignment->user_id)->first();
                                $assigner = \App\User::where('id', $itemAssignment->assigned_by)->first();

                                $accessoriesAssigned = \App\AccessoryAssigned::all()->where('assignment_id', $itemAssignment->id)
                                ->all();

                                $accessories = [];

                                foreach ($accessoriesAssigned as $acc) {
                                   $accessories[] = \App\ItemAccessory::all()->where('id',$acc->accessory_id)->first();
                                }

                            @endphp

                            <tr>
                                <td>
                                    Name: <strong>{{ $item->name }}</strong>  <br>

                                    Serial No: <strong>{{ $item->serial_number }}</strong>  <br>

                                    Category : <strong>{{ $item->itemCategory->name }}</strong>  <br>

                                    @if(count($accessories) > 0)
                                        <div>
                                            <h5>Accessories <span class="badge">{{ count($accessories) }}</span></h5>
                                            @foreach($accessories as $accessory)
                                                <small>{{ $accessory->name }}</small>  <br>
                                            @endforeach
                                        </div>
                                    @else
                                        <br>
                                        <span class="label label-info">No Accessory</span>
                                        <br>
                                    @endif

                                </td>

                                <td>
                                    Name:
                                        <strong>{{ $user->getName() }} </strong>
                                    <br>
                                    Phone:
                                        <strong>
                                            <a href="{{ route('assign.sms.get', $itemAssignment->id) }}">{{ $user->phone_number }}</a>
                                        </strong>   <br>

                                     E-mail :
                                        <strong>
                                            <a href="{{ route('assign.email.get', $itemAssignment->id) }}">{{ $user->email }}</a>
                                        </strong>  <br>
                                    {{--E-mail : <a href="mailto:{{ $user->email }}">{{ $user->email }} </a>  <br>--}}
                                </td>

                                <td>
                                    Assigned On :
                                    <strong style="color: #2ab27b">{{ \App\Utility\Utils::getReadableDateTime($itemAssignment->assigned_at)  }} </strong><br>

                                    Supposed Returned On:<br>
                                    <strong style="color: #985f0d">{{ \App\Utility\Utils::getReadableDateTime($itemAssignment->supposed_returned_at)  }}</strong>
                                    <br>

                                    Returned On:  <strong style="color: #0a7ef4">{{ $itemAssignment->returned_at ?  \App\Utility\Utils::getReadableDateTime($itemAssignment->returned_at) : 'Not Yet'}}</strong>  <br>

                                </td>

                                <td>
                                    Name: <strong>{{ $assigner->getName() }}</strong>  <br>

                                    Phone: <strong>{{ $assigner->phone_number }}</strong>  <br>

                                    E-mail : <strong>{{ $assigner->email }}</strong>  <br>
                                </td>



                                <td>

                                    @if($itemAssignment->supposed_returned_at < \Carbon\Carbon::now()->toDateTimeString())
                                        <span class="label label-warning">OVERDUE</span>
                                    @else
                                        <span class="label label-success">NOT OVERDUE</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!isset($itemAssignment->returned_at))
                                        <a class="btn btn-success" href="{{ route('assign.return.get',[$itemAssignment->id])}}">
                                            <i class="fa fa-repeat"></i>
                                            Mark Returned
                                        </a>
                                        @else
                                        <span class="label label-success">RETURNED</span>
                                    @endif



                                </td>

                            </tr>

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

            $('#assigned_items_table').DataTable({
                "bInfo" : false,
                "language": {
                    "search": "Search Item :"
                }
            });


        });


    </script>

@endsection

