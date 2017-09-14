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

             </div>

                <h1 class="page-header" align="center"> <strong>SEND SMS TO ASSIGNED USER : </strong>
                <span>{{ $user->getName() }}</span></h1>

                <div class="row">

                    <div class="col-md-8 col-md-offset-2">

                        <div class="response-notification"></div>

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
                                    {{--<button class="btn btn-primary" type="submit" id="sendMailButton">--}}
                                        {{--<i class="fa fa-envelope-o"></i>--}}
                                        {{--SEND MESSAGE--}}
                                    {{--</button>--}}

                                    <button type="submit"
                                            class="btn btn-success"
                                            id="sendSMSButton"
                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing ..."
                                    >
                                        <i class="fa fa-envelope-o"> </i>
                                        SEND SMS MESSAGE
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
            var $sendSMSButton = $('#sendSMSButton');

            $('#sendMailToAssigned').submit(function(e) {
                e.preventDefault();

                $sendSMSButton.button('loading');
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
                        $sendSMSButton.removeClass('disabled');
                        $sendSMSButton.html('SEND MESSAGE');
                        if( response.message !== null){
                            $('.response-notification').replaceWith('<h5 class="alert alert-success response-notification">'+ response.message +'</h5>');
                        }
                    })
                    .fail(function (e) {
                        $sendSMSButton.removeClass('disabled');
                        $sendSMSButton.html('SEND MESSAGE');
                        if(e.status === 500){
                            $('.response-notification').replaceWith('<h5 class="alert alert-danger response-notification">An error occurred when trying to send the SMS, Please Try Again Later. </h5>')
                        }

//                        console.log(e)
                    })
                    .always(function () {
                        $sendSMSButton.button('reset');
                    });
            });


        });


    </script>
@endsection

