@extends('layouts.app')
@section('title', 'Item Request')
@section('styles')
    <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
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

                <h1 class="page-header" align="center"> <strong>ITEMS REQUEST PROCESS</strong> </h1>

                <div class="row">

                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                DETAILS OF THE ITEM YOU ARE REQUESTING
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


                            </div> <!--table responsive-->

                        </div>
                        <div class="panel-footer">
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">



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
                                ITEM REQUEST DETAILS
                            </div>

                            <form action="{{ route('request.post', $item->slug) }}" class="form" method="post">

                                {{ csrf_field() }}

                            <div class="panel-body">

                                <p class="bg-info" style="padding: 15px; margin-bottom: 50px">
                                    You have accepted terms and rights . Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci alias aut debitis eligendi eos ex iste itaque optio quaerat qui rem reprehenderit repudiandae soluta totam veritatis voluptas voluptate, voluptatibus voluptatum.
                                </p>

                                <div class="form-group">
                                    <label for="custom_accessories_selection">Accessory Selection</label>
                                    <div>
                                        <p class="bg-info" style="padding: 10px;">
                                            Select the desired accessories.
                                            <span class="btn btn-info" data-toggle="tooltip" title="Among the list of the current available accessories">
                                            <i class="fa fa-info"></i>
                                        </span>
                                        </p>
                                    </div>
                                    <select name="accessories[]" id="custom_accessories_selection" multiple="multiple" class="form-control" required>
                                        @foreach($accessories as $accessory)
                                            <option value="{{ $accessory->id }}">{{ $accessory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="item_date_acquired" >Pick Up Date </label>

                                    <div class='input-group date' id='pickup_date'>
                                        <input type='text' class="form-control" id="pickup_date" name="pickup_date"
                                               value="" required/>
                                        <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    </div>
                                    <div class="help-block">Specify the date & time you will take the item.
                                        <span class="btn btn-info" data-toggle="tooltip" title="The return date is deducted by time span period of the item">
                                            <i class="fa fa-info"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('pickup_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('pickup_date') }}</strong>
                                    </span>
                                    @endif
                                </div>




                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-ticket"></i>
                                    REQUEST ITEM
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
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>


    <script>
        $(document).ready(function () {

            $('#pickup_date').datetimepicker({
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss',
                showClear: true
            });


            $('[data-toggle="tooltip"]').tooltip();

            $("#custom_accessories_selection").select2();
        });


    </script>
@endsection

