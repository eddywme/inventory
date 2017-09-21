@extends('layouts.app')
@section('title', 'Assigned Items')
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

                @if (session('error-status'))
                    <div class="alert alert-danger" style="margin-top: 10px">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                <h1 class="page-header"> <strong>API SUBSCRIPTION INFOS</strong> </h1>


                <div class="table-responsive">

                <table class="table table-striped" id="api_info">
                    <thead>
                    <tr>
                        <th>Api Client</th> <th>Issued By</th> <th>State</th> <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($apiSubscriptions as $apiSubscription)
                            @php

                                $user = \App\User::all()->where('id', $apiSubscription->user_id)->first();
                                $admin = \App\User::all()->where('id', $apiSubscription->issued_by)->first();


                            @endphp

                            <tr>
                                <td>
                                    Name: {{ $user->getName() }} <br>
                                    E-mail: {{ $user->email }} <br>
                                    Phone number : {{ $user->phone_number }} <br>
                                </td>

                                <td>
                                    Name: {{ $admin->getName() }} <br>
                                    E-mail: {{ $admin->email }} <br>
                                    Phone number : {{ $admin->phone_number }} <br>
                                </td>

                                <td>
                                     <span class="label label-info">{{ $apiSubscription->getState() }}</span>
                                </td>

                                <td>
                                    @if($apiSubscription->state === 1)
                                        <a href="" class="btn btn-danger">Revoke Token</a>
                                        @else
                                        <a href="{{ route('assignToken.get') }}" class="btn btn-danger">Send New Token </a>
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

            $('#api_info').DataTable({
                "bInfo" : false,
                "language": {
                    "search": "Search Api Info :"
                }
            });


        });


    </script>

@endsection

