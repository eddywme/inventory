@extends('layouts.app')
@section('title', 'Items Conditions')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
            padding-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">



                <h1 class="page-header"> <strong>REGISTERED ITEM CONDITIONS</strong> </h1>

                @if (session('status'))
                    <div class="alert alert-success">
                        <h5>{{ session('status') }}</h5>
                    </div>
                @endif

                <a class="btn btn-primary" href="{{ route('item-conditions.create') }}" style="margin: 10px;">
                    <i class="fa fa-plus-circle"></i> Add Item Condition
                </a>

                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Names</th><th>Description</th><th>Added On</th> <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($itemConditions as $itemCondition)

                        <tr>
                            <td>
                               {{ $itemCondition->name }}
                            </td>


                            <td>
                                {{ substr($itemCondition->description, 0, 20)  }} ...
                            </td>

                            <td>
                                {{   date("F jS, Y H:i:s",strtotime( $itemCondition->created_at)) }}
                            </td>

                            <td>
                                <a href="{{ route("item-conditions.edit", $itemCondition->slug) }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>

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
                    "search": "Search Item Condition:"
                }
            });


        });


    </script>

@endsection

