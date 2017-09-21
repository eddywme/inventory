@extends("layouts.app")
@section('title', 'Login')
@section('styles')
    <style>
        .login-panel{
            margin-top: 40px;
            margin-bottom: 120px;
        }
        .error-class {
            color:red;  z-index:0; position:relative; display:block; text-align: left; font-style: italic; font-size: 12px}
    </style>
@endsection
@section("content")


        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                            <form  role="form" method="POST" action="{{ route('login') }}" id="login_form">
                                {{ csrf_field() }}
                            <fieldset>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <i>{{ $errors->first('email') }}</i>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <i>{{ $errors->first('password') }}</i>
                                    </span>
                                    @endif
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-lg  btn-block">Login</button>

                                <hr>
                                <h5 align="center">Or</h5>
                                <a href="{{ url('/register') }}" class="btn btn-lg btn-success btn-block">Create New Account</a>

                                <h5><a  class="btn btn-link" href="{{ route('password.request') }}"> <div class="">Forgot Your Password? Click Here</div></a>
                                </h5>
                            </fieldset>

                        </form>
                    </div>
                </div>

            </div>

        </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script>
        $('#login_form').validate({
            // validation rules for ticket form
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

                email: {
                    required:true
                },

                password: {
                    required:true
                },



            },
            messages: {

                email: {
                    required: "The E-mail is required"

                },

                password: {
                    required: "The Password is required"

                }
            }



        });
    </script>
@endsection