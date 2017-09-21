@extends('layouts.app')
@section('title', 'Registered Items')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 0px;
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

                <h1 class="page-header" align="center"> <strong>ITEMS RETURN PROCESS</strong> </h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                DETAILS OF THE ITEM WHEN WAS ASSIGNED
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

                                    @if(isset($itemAccessories))

                                        <ul class="list-group">
                                            <li class="list-group-item list-group-item-heading list-group-item-info">
                                                <span class="badge">{{  count( $itemAccessories) }}</span>
                                                Accessories Assigned
                                            </li>
                                            @foreach($itemAccessories as $itemAccessory)
                                                <a  href="{{ route('item-accessories.show', $itemAccessory->slug) }}" class="list-group-item">{{ $itemAccessory->name }}</a>
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

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                ASSIGNEMENT INFO
                            </div>
                            <div class="panel-body">

                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>User :</td>
                                        <td>{{ $user->getName() }}</td>
                                    </tr>


                                    <tr>
                                        <td>Took On : </td>
                                        <td><span class="label label-info">{{ \App\Utility\Utils::getReadableDateTime($itemAssignment->assigned_at)  }}</span> </td>
                                    </tr>

                                    <tr>
                                        <td>Supposed Returned On :</td>
                                        <td> <span  class="label label-warning">{{ \App\Utility\Utils::getReadableDateTime($itemAssignment->supposed_returned_at) }}  </span></td>
                                    </tr>

                                    <tr>
                                        <td> Was Assigned By: </td>
                                        <td> {{ $admin->getName() }}</td>
                                    </tr>


                                    </tbody>
                                </table>





                            </div>
                            <div class="panel-footer">

                            </div>
                        </div>

                        @if (session('error-status'))
                            <div class="alert alert-danger" style="padding: 5px">
                                <h5>{{ session('error-status') }}</h5>
                            </div>
                        @endif

                        @if (session('success-status'))
                            <div class="alert alert-success" style="padding: 5px">
                                <h5>{{ session('success-status') }}</h5>
                            </div>
                        @endif

                        <div class="panel panel-info">

                            <div class="panel-heading">
                                ITEM RETURNED DESCRIPTION
                            </div>

                            <form action="{{ route('assign.return.post', $itemAssignment->id) }}" class="form" method="post">

                                {{ csrf_field() }}

                            <div class="panel-body" style="padding: 10px">




                                    <div class="form-group">

                                            <label for="returned_condition">Select The Item Returned Condition:</label>
                                            <select name="returned_condition" id="returned_condition" class="form-control" required>
                                                <option value="" disabled></option>
                                                @foreach($itemConditions as $itemCondition)
                                                    <option value="{{ $itemCondition->id  }}">{{ $itemCondition->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="comment">Comment: </label>
                                        <textarea name="returned_comment" id="comment"  rows="8" class="form-control" placeholder="Comment [ Optional ]"></textarea>
                                    </div>


                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-ticket"></i>
                                    CONFIRM ITEM RETURNMENT
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>

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

            $('#first_name_').autocomplete({
                serviceUrl: '/assignment/firstNamesEndPoint'
            });

            $('#last_name_').autocomplete({
                serviceUrl: '/assignment/lastNamesEndPoint'
            });

            $('#email_').autocomplete({
                serviceUrl: '/assignment/emailsEndPoint'
            });

        });

    </script>
@endsection

