@extends('layouts.app')
@section('title', 'Sending Mail')
@section('styles')

    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 0;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">

                    <div style="margin-top: 30px">
                        <div class="on-success" >
                        <div class="on-error">
                    </div>



                    </div>

                <h1 class="page-header" align="center"> <strong>SEND SMS TO ASSIGNED USER : </strong>
                <span>{{ $user->getName() }}</span></h1>

                <div class="row">

                    <div class="col-md-8 col-md-offset-2">



                        @if (session('error-status'))
                            <div class="alert alert-danger" style="padding: 5px">
                                <h5>{{ session('error-status') }}</h5>
                            </div>
                        @endif

                        @if (session('success-status'))
                            <div class="alert alert-success" style="padding: 5px">
                                <h5>{{ session('success-status') }}</h5>
                            </div>
                        @endif

                        <div class="panel panel-info">

                            <div class="panel-heading">
                              Message will be sent to: <strong>{{ $user->getName() }}</strong>  via his/her phone number  <strong>{{ $user->phone_number  }}</strong>
                            </div>

                            <form action="{{ route('send.sms.toAssigned', $itemAssignment->id) }}" class="form" method="post" id="sendMailToAssigned">

                                {{ csrf_field() }}

                                <div class="panel-body">



                                    <div class="form-group">
                                        <textarea name="message" id="message"  rows="5" class="form-control" placeholder="Enter Message Text" required></textarea>

                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                        @endif
                                    </span>
                                    </div>


                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-primary" type="submit" id="sendMailButton">
                                        <i class="fa fa-envelope-o"></i>
                                        SEND MESSAGE
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>

            </div>




        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var $sendMailButton = $('#sendMailButton');

            $('#sendMailToAssigned').submit(function(e) {
                e.preventDefault();

                $sendMailButton.addClass('disabled');
                $sendMailButton.html('SENDING ...');
                $.ajax({
                    method: "POST",
                    timeout: 7000,
                    url: '{{ route('send.sms.toAssigned', $itemAssignment->id) }}',
                    data: {
                        message:  $('textarea#message').val(),
                        _token: "{{ csrf_token() }}"
                    }
                })
                    .done(function( response ) {
                        $sendMailButton.removeClass('disabled');
                        $sendMailButton.html('SEND MESSAGE');
                        if( response.message !== null){
                            $('.on-success').replaceWith('<h5 class="alert alert-success on-success">'+ response.message +'</h5>');
                        }
                    })
                    .fail(function (e) {
                        $sendMailButton.removeClass('disabled');
                        $sendMailButton.html('SEND MESSAGE');
                        if(e.status === 500){
                            $('.on-error').replaceWith('<h5 class="alert alert-danger on-error">An error occurred when trying to send the SMS, Please Try Again Later. </h5>')
                        }

//                        console.log(e)
                    });
            });


        });


    </script>
@endsection

