@extends('layouts.app')
@section('title', 'Items Accessories')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
            padding-top: 10px;
        }
        .img-accessory{
            width: 160px;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">



                <h1 class="page-header"> <strong>REGISTERED ITEM ACCESSORIES</strong> </h1>

                @if (session('error-status'))
                    <div class="alert alert-success">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                @if (session('success-status'))
                    <div class="alert alert-success">
                        <h5>{{ session('success-status') }}</h5>
                    </div>
                @endif


                <a href="{{ route('item-accessories.create', null) }}" class="btn btn-primary"
                   style="margin-bottom: 20px">
                    <i class="fa fa-plus fa-fw"></i>
                    Add Accessory
                </a>




                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Accessory Name</th><th>From Item</th> <th>Status</th> <th>Description</th><th>Edit</th><th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($itemAccessories as $itemAccessory)

                        <tr>

                            <td>
                               <a href="{{ route("item-accessories.show", $itemAccessory->slug) }}">{{ $itemAccessory->name }}</a>
                            </td>

                            <td>
                                @if($itemAccessory->item)
                                Item Name : {{ $itemAccessory->item->name }} <br>
                                Item Serial Number : {{ $itemAccessory->item->serial_number }}
                                @else
                                    <h5>STANDALONE ACCESSORY</h5>
                                @endif
                            </td>

                            <td>

                                @if($itemAccessory->status === \App\Utility\AccessoryStatus::$ACCESSORY_TAKEN)
                                    <span class="label label-danger"> {{  $itemAccessory->showStatusName() }}</span>
                                @elseif($itemAccessory->status === \App\Utility\AccessoryStatus::$ACCESSORY_RESERVED)
                                    <span class="label label-warning"> {{  $itemAccessory->showStatusName() }}</span>
                                @elseif($itemAccessory->status === \App\Utility\AccessoryStatus::$ACCESSORY_AVAILABLE)
                                    <span class="label label-success"> {{  $itemAccessory->showStatusName() }}</span>
                                @endif
                            </td>

                            <td width="30%">
                                {{ substr($itemAccessory->description, 0, 100)  }} ...
                            </td>

                            <td>
                                <a href="{{ route('item-accessories.edit', $itemAccessory->slug) }}">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                            </td>


                            <td>
                                <form  action="{{ route('item-accessories.destroy', $itemAccessory->slug) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button class="btn btn-default"
                                            data-toggle="confirm"
                                            data-title="Item Accessory deletion"
                                            data-message="Do you really want to delete the Item Accessory ? <br>
                                                 Once the Item Accessory is deleted all its related data are deleted and the action cannot be reverted back.<br>"
                                            data-type="danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
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
                    "search": "Search Accessory:"
                }
            });


        });


    </script>

@endsection

