<!DOCTYPE html>
<html>
<head>
    <title>Request Accepted</title>
</head>
<body>
<h2>Hi Mr. {{ $user->first_name." ".$user->last_name}}</h2>
Your request has been accepted .
<div class="panel panel-primary">
    <div class="panel-heading">
        DETAILS OF THE ITEM YOU HAVE BEEN APPROVED
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
</body>
</html>