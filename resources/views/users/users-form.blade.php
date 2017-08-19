@extends('layouts.app')
@section('styles')
    <style>
        .register-panel{
            margin-top: 40px;
            margin-bottom: 120px;
        }

        .error-class {
            color:red;  z-index:0; position:relative; display:block; text-align: left; font-style: italic; font-size: 12px}


    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
                <div class="alert alert-success">
                    <h5>{{ session('status') }}</h5>
                </div>
            @endif
            <div class="panel panel-default register-panel">
                <div class="panel-heading">{{ isset($user)?  'EDIT PROFILE' : 'CREATING AN ACCOUNT' }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($user)? route('users.update', $user->slug) : route('register') }}" id="user_registration_form">
                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="{{ isset($user)? 'PUT' : 'POST' }}" required>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name"
                                       value="{{ isset($user)? $user->first_name : old('first_name') }}"
                                       required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name"
                                       value="{{ isset($user)? $user->last_name : old('first_name') }}"
                                       required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ isset($user)? $user->email : old('first_name') }}"
                                       required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="tel" class="form-control" name="phone_number"
                                       value="{{ isset($user)? $user->phone_number : old('first_name') }}"
                                       required>

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i>
                                    {{ isset($user)? 'UPDATE PROFILE' : 'SAVE ACCOUNT' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>

    <script>
        $('document').ready(function () {

            /*Validation codes*/
            $('#user_registration_form').validate({
                // validation rules for registration form
                errorClass: "error-class",
                validClass: "valid-class",
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                onError : function(){
                    $('.input-group.error-class').find('.help-block.form-error').each(function() {
                        $(this).closest('.form-group').addClass('error-class').append($(this));
                    });
                },


                rules: {

                    first_name: {
                        required:true
                    },

                    last_name: {
                        required:true
                    },

                    email: {
                        required: true

                    },


                    phone_number: {
                        required: true

                    },
                    password: {
                        required: true

                    },
                    password_confirmation : {
                        minlength : 6,
                        equalTo : "#password"
                    }




                },
                messages: {

                    first_name: {
                        required: "The field First name is required"

                    },

                    last_name: {
                        required: "The field Last Name is required"

                    },

                    email : {
                        required:"The field E-mail is required"

                    },

                    phone_number : {
                        required: "The field Phone Number is required"

                    },

                    password : {
                        required: "The field Password is required"

                    },

                    password_confirmation : {
                        required: "The Password confirmation field is required",
                        equalTo: "Please repeat the same password again"

                    }
                }


            });

            /* Date-time picker codes*/
            $('#time').datetimepicker({
                minDate : new Date(),
                format: 'YYYY-MM-DD HH:mm:ss'
            });





        });

    </script>

@endsection
