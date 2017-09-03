<!DOCTYPE html>
<html>
<head>
    <title>Request Accepted</title>
</head>
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')  }}">
<body>
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h2>Hi Mr/Ms. <strong>{{ $user->first_name." ".$user->last_name}}</strong> </h2>
            <p>
                Your request has been accepted .
            </p>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    DETAILS OF THE ITEM YOU HAVE BEEN APPROVED
                </div>
                <div class="panel-body ">
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



                            </tbody>
                        </table>

                    </div> <!--table responsive-->

                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>