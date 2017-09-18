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

                <h1 class="page-header"> <strong>REGISTERED USERS</strong> </h1>

                @if(App\Utility\Utils::isSuperAdmin())
                    <a href="{{ route('manage.roles.index') }}" class="btn btn-primary" style="margin-bottom: 20px">
                        <i class="fa fa-users"></i>
                        Manage Roles
                    </a>
                @endif

                <table class="table table-striped" id="organizers_table">
                    <thead>
                    <tr>
                        <th>Names</th><th>E-mail</th><th>Phone</th> <th>Role</th> <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)

                        <tr>
                            <td>
                                {{ $user->first_name." ".$user->last_name }}
                            </td>

                            <td>
                                {{  $user->email }}
                            </td>

                            <td>
                                {{  $user->phone_number }}
                            </td>

                            <td>
                                {{ strtoupper($user->role->name)  }}
                            </td>



                            <td>
                                <form  action="{{ route('users.destroy', $user->slug) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button class="btn btn-default"
                                            data-toggle="confirm"
                                            data-title="User deletion"
                                            data-message="Do you really want to delete the User? <br>
                                                 Once the User is deleted all his data are deleted and the action cannot be reverted back."
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
                    "search": "Search User :"
                }
            });


        });


    </script>

@endsection

