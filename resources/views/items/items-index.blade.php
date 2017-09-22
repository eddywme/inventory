@extends('layouts.app')
@section('title', 'Registered Items')
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
                    <div class="alert alert-warning" style="margin-top: 10px">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                <h1 class="page-header"> <strong>REGISTERED ITEMS</strong> </h1>

                <a class="btn btn-primary" href="{{ route('items.create') }}" style="margin: 10px;">
                    <i class="fa fa-plus-circle"></i> Add Item
                </a>

                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Names</th><th>Category</th><th>TimeSpan</th><th>Serial Number</th><th>Status</th>
                        <th>Edit</th><th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)

                        <tr>
                            <td>
                               <a href="{{ route("items.show", $item->slug) }}">{{ $item->name }}</a>
                            </td>

                            <td>
                                {{  $item->itemCategory->name }}
                            </td>

                            <td>
                                {{  $item->timeSpanObject()['hours']." hrs ".$item->timeSpanObject()['days']." days ".$item->timeSpanObject()['months']." months "
                                 .$item->timeSpanObject()['years']." years" }}
                            </td>

                            <td>
                                {{  $item->serial_number }}
                            </td>

                            <td>
                                @if($item->status === \App\Utility\ItemStatus::$ITEM_TAKEN)
                                    <span class="label label-danger"> {{  $item->showStatusName() }}</span>
                                @elseif($item->status === \App\Utility\ItemStatus::$ITEM_RESERVED)
                                    <span class="label label-warning"> {{  $item->showStatusName() }}</span>
                                @elseif($item->status === \App\Utility\ItemStatus::$ITEM_AVAILABLE)
                                    <span class="label label-success"> {{  $item->showStatusName() }}</span>
                                @endif

                            </td>

                            <td>
                                @if($item->is_available())
                                    <a href="{{ route('items.edit', $item->slug) }}"><i class="fa fa-pencil-square-o"></i></a>
                                @else
                                    <span class="label label-warning">NOT AVAILABLE</span>
                                @endif
                            </td>


                            <td>
                                @if($item->is_available())
                                <form  action="{{ route('items.destroy', $item->slug) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button class="btn btn-default"
                                            data-toggle="confirm"
                                            data-title="Item deletion"
                                            data-message="Do you really want to delete the Item? <br>
                                                 Once the Item is deleted all its data are deleted and the action cannot be reverted back."
                                            data-type="danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </form>
                                @else
                                    <span class="label label-warning">NOT AVAILABLE</span>
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

            $('#organizers_table').DataTable({
                "bInfo" : false,
                "language": {
                    "search": "Search Item :"
                }
            });


        });


    </script>

@endsection

