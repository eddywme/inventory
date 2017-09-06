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

                @if (session('status'))
                    <div class="alert alert-success">
                        <h5>{{ session('status') }}</h5>
                    </div>
                @endif

                {{--<a class="btn btn-primary" href="{{ route('item-categories.create') }}" style="margin: 10px;">--}}
                    {{--<i class="fa fa-plus-circle"></i> Add Item Accessory--}}
                {{--</a>--}}

                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Accessory Name</th><th>From Item</th><th>Description</th><th>Edit</th><th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($itemAccessories as $itemAccessory)

                        <tr>

                            <td>
                               <a href="{{ route("item-accessories.show", $itemAccessory->slug) }}">{{ $itemAccessory->name }}</a>
                            </td>

                            <td>
                               Item Name : {{ $itemAccessory->item->name }} <br>
                                Item Serial Number : {{ $itemAccessory->item->serial_number }}
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
                                <form  action="{{ route('item-categories.destroy', $itemAccessory->slug) }}" method="POST">
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

