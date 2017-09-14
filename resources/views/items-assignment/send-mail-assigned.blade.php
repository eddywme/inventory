@extends('layouts.app')
@section('title', 'Sending Mail')
@section('styles')

    <style>
        .main-content{
            background: #fff;
        }
        footer{
            margin-top: 0px;
        }
    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">



                <h1 class="page-header" align="center"> <strong>SEND E-MAIL TO ASSIGNED USER : </strong>
                <span>{{ $user->getName() }}</span></h1>


                <div class="row">



                    <div class="col-md-8 col-md-offset-2">

                        <div class="response-notification"></div>

                        <div class="panel panel-info">

                            <div class="panel-heading">
                              Message will be sent to: <strong>{{ $user->getName() }}</strong>  via his/her e-mail address <strong>{{ $user->email  }}</strong>
                            </div>

                            <form action="{{ route('send.email.toAssigned', $itemAssignment->id) }}" class="form" method="post" id="sendMailToAssigned">

                                {{ csrf_field() }}

                                <div class="panel-body">



                                    <div class="form-group">
                                        <textarea name="message" id="message"  rows="12" class="form-control" placeholder="Enter Message Text" required></textarea>

                                        @if ($errors->has('message'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                        @endif
                                    </span>
                                    </div>


                                </div>
                                <div class="panel-footer">


                                    <button type="submit"
                                            class="btn btn-success"
                                            id="sendMailButton"
                                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing ..."
                                    >
                                        <i class="fa fa-envelope-o"> </i>
                                        SEND MAIL
                                    </button>
                                </div>
                            </form>
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

                $sendMailButton.button('loading');

                $.ajax({
                    method: "POST",
                    timeout: 7000,
                    url: '{{ route('send.email.toAssigned', $itemAssignment->id) }}',
                    data: {
                        message:  $('textarea#message').val(),
                        _token: "{{ csrf_token() }}"
                    }
                })
                    .done(function( response ) {
                        if(response.message) {
                            $('.response-notification').replaceWith('<h5 class="alert alert-success response-notification">'+ response.message +'</h5>')
                            console.log(response.message)
                        }

                    })
                    .fail(function (e) {

                        if(e.responseJSON){
                            $('.response-notification').replaceWith(
                                '<h5 class="alert alert-warning response-notification" >'+e.responseJSON.message+'</h5>'
                            )
                        }

                        if(e.statusText === "timeout"){
                            $('.response-notification').replaceWith(
                                '<h5 class="alert alert-warning response-notification" > The request took long than expected. Try again later.</h5>'
                            )
                        }

                    })
                    .always(function () {
                        $sendMailButton.button('reset');
                    });
            });


        });


    </script>
@endsection

