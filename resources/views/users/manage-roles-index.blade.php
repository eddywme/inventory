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

                @if (session('error-status'))
                    <div class="alert alert-danger">
                        <h5>{{ session('error-status') }}</h5>
                    </div>
                @endif

                    @if (session('success-status'))
                        <div class="alert alert-success">
                            <h5>{{ session('success-status') }}</h5>
                        </div>
                    @endif

                <h1 class="page-header text-center"> <strong>MANAGE USERS ROLES</strong> </h1>


                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                            <div class="panel panel-info">

                                <div class="panel-heading">
                                    FIND USER TO ASSIGN A ROLE
                                </div>

                                <form action="{{ route('assign.role.post') }}" class="form" method="post">

                                    {{ csrf_field() }}



                                    <div class="panel-body">


                                        <div class="form-group">
                                            <div>
                                                <p class="bg-info" style="padding: 10px;">
                                                    Make sure to check whether you are assigning the Role to the correct user's email address.
                                                </p>
                                            </div>
                                            <label for="email_">E-mail Address</label>
                                            <input type="text" class="form-control" placeholder="E-mail" id="email_" name="email" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <i>{{ $errors->first('email') }}</i>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select name="role" id="role" class="form-control">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">  {{ strtoupper($role->name)  }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                    </div>
                                    <div class="panel-footer">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-key"></i>
                                            ASSIGN ROLE
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div class="col-md-6">



                        </div>

                        </div>
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


            $('#email_').autocomplete({
                serviceUrl: '/assignment/emailsEndPoint'
            });


        });

    </script>

@endsection

