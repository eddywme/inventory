@extends('layouts.app')
@section('title', 'Items Categories')
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



                <h1 class="page-header"> <strong>REGISTERED ITEM CATEGORIES</strong> </h1>

                @if (session('status'))
                    <div class="alert alert-success">
                        <h5>{{ session('status') }}</h5>
                    </div>
                @endif

                <a class="btn btn-primary" href="{{ route('item-categories.create') }}" style="margin: 10px;">
                    <i class="fa fa-plus-circle"></i> Add Item Category
                </a>

                <div class="table-responsive">

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Names</th><th>No Of Items</th><th>Description</th><th>Added On</th> <th>Edit</th>
                        @if(\App\Utility\RoleUtils::isSysAdmin())
                        <th>Delete</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($itemCategories as $itemCategory)

                        <tr>
                            <td>
                               <a href="{{ route("item-categories.edit", $itemCategory->slug) }}">{{ $itemCategory->name }}</a>
                            </td>

                            <td>
                                @php
                                $itemCategoryCount = \App\Item::all()->where('category_id', $itemCategory->id)->count();
                                @endphp
                                {{  $itemCategoryCount }} Items
                            </td>

                            <td>
                                {{ substr($itemCategory->description, 0, 20)  }} ...
                            </td>

                            <td>
                                {{   date("F jS, Y H:i:s",strtotime( $itemCategory->created_at)) }}
                            </td>

                            <td>
                                <a href="{{ route("item-categories.edit", $itemCategory->slug) }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>

                            </td>

                            @if(\App\Utility\RoleUtils::isSysAdmin())
                                <td>
                                    <form  action="{{ route('item-categories.destroy', $itemCategory->slug) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{ csrf_field() }}
                                        <button class="btn btn-warning"
                                                data-toggle="confirm"
                                                data-title="Item Category deletion"
                                                data-message="Do you really want to delete the Item Category ? <br>
                                                 Once the Item Category is deleted all its related data are deleted and the action cannot be reverted back.<br>"
                                                data-type="danger">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </form>
                                </td>
                            @endif



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
                    "search": "Search Item Category:"
                }
            });


        });


    </script>

@endsection

