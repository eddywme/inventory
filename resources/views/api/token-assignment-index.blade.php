@extends('layouts.app')
@section('title', 'Item Assignment')
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 40px;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-10 col-md-offset-1">



                    <span class="on-success"></span>
                    <span class="on-error"></span>


                <h1 class="page-header" align="center"> <strong>API TOKEN ASSIGNMENT PROCESS</strong> </h1>
                <h6>An API Token will be sent to the user's mail after a successful operation. The user will be using the API token to make requests to the REST Service</h6>
                <div class="row">

                        <div class="panel panel-info">

                            <div class="panel-heading">
                                FIND USER'S E-MAIL TO SEND THE API TOKEN
                            </div>

                            <form action="{{ route('sendToken.post') }}" id="assignTokenForm" method="post">

                            <div class="panel-body">

                                {{ csrf_field() }}

                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="E-mail" id="email_" name="email" required>
                                    </div>






                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary" type="submit" id="assignTokenButton">
                                    <i class="fa fa-key"></i>
                                    SEND API TOKEN
                                </button>
                            </div>

                        </form>

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
                serviceUrl: '{{ route('emails.endpoint')}}'
            });

        });

        var $assignTokenButton = $('#assignTokenButton');
        var $assignTokenForm = $('#assignTokenForm');

        $assignTokenForm.on('submit', function(e) {
            e.preventDefault();

            $assignTokenButton.addClass('disabled');
            $assignTokenButton.html('SENDING ...');
            $.ajax({
                method: "POST",

                url: '{{ route('sendToken.post') }}',
                timeout: 7000,
                data: {
                    email:  $('input#email_').val(),
                    _token: "{{ csrf_token() }}"
                }
            })
                .done(function( response ) {
                    $assignTokenButton.removeClass('disabled');
                    $assignTokenButton.html('SEND API TOKEN');
                    if( response.message !== null){
                        $('.on-success').replaceWith('<h5 class="alert alert-success on-success">'+ response.message +'</h5>');
                    }

                    console.log(response)
                })
                .fail(function (e) {
                    $assignTokenButton.removeClass('disabled');
                    $assignTokenButton.html('SEND API TOKEN');
                    if(e.responseJSON.message !== null && e.responseJSON.message !== undefined){
                        $('.on-error').replaceWith('<h5  class="alert alert-danger on-error">'+ e.responseJSON.message+'</h5>')
                    }
                    console.log(e)
                });
        });



    </script>
@endsection

