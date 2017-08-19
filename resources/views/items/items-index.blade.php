@extends('layouts.app')
@section('title', 'Users')
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
                    <div class="alert alert-success">
                        <h5>{{ session('status') }}</h5>
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
                        <th>Names</th><th>Category</th><th>TimeSpan</th><th>Serial Number</th><th>Availability</th>
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
                                {{  $item->is_available ? "AVAILABLE" : "TAKEN" }}
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

