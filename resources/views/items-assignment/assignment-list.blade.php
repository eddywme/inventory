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

                @if (session('status'))
                    <div class="alert alert-success" style="margin-top: 10px">
                        <h5>{{ session('status') }}</h5>
                    </div>
                @endif

                <h1 class="page-header"> <strong>ASSIGNED ITEMS</strong> </h1>


                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Item Info</th><th>Assigned To</th><th>Time Info</th><th>Assigned By</th><th>Mark Returned</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($itemAssignments as $itemAssignment)
                            @php
                                $item = \App\Item::where('id', $itemAssignment->item_id)->first();
                                $user = \App\User::where('id', $itemAssignment->user_id)->first();
                                $assigner = \App\User::where('id', $itemAssignment->assigned_by)->first()


                            @endphp

                            <tr>
                                <td>
                                    Name: {{ $item->name }} <br>
                                    Serial No: {{ $item->serial_number }} <br>
                                    Category : {{ $item->itemCategory->name }} <br>
                                </td>

                                <td>
                                    Name: {{ $user->name() }} <br>
                                    Phone: {{ $user->phone_number }} <br>
                                    E-mail : {{ $user->email }} <br>
                                </td>

                                <td>
                                    Assigned On : {{ \App\Utility\Utils::getReadableDateTime($itemAssignment->assigned_at)  }} <br>
                                    Suppoed Returned On:<br> {{ \App\Utility\Utils::getReadableDateTime($itemAssignment->supposed_returned_at)  }} <br>
                                    Returned On: {{ $itemAssignment->returned_at ?  $itemAssignment->returned_at : 'Not Yet'}} <br>

                                </td>

                                <td>
                                    Name: {{ $assigner->name() }} <br>
                                    Phone: {{ $assigner->phone_number }} <br>
                                    E-mail : {{ $assigner->email }} <br>
                                </td>

                                <td>
                                    <div class="btn btn-success">
                                        <i class="fa fa-arrow-up"></i>
                                        Mark Returned
                                    </div>
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

            $('#organizers_table').DataTable({
                "bInfo" : false,
                "language": {
                    "search": "Search Item :"
                }
            });


        });


    </script>

@endsection

