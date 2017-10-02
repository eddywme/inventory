@extends('layouts.app')
@section('title')
    {{ isset($item)? 'Edit Condition' : 'Registering an Item Condition' }}
@endsection
@section('styles')
    <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/simplemde.min.css') }}" rel="stylesheet">
    <style>
        .register-panel{
            margin-top: 40px;
            margin-bottom: 10px;
        }

        form{
            margin-bottom: 100px;
        }

    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    <h5>{{ session('status') }}</h5>
                </div>
            @endif
            <div class="panel panel-default register-panel">
                <div class="panel-heading"><h3 align="center">{{ isset($itemCondition)?  'EDIT ITEM CONDITION' : 'REGISTERING AN ITEM CONDITION' }}</h3>
                <h6 align="center">All The Fields Are Required Unless Specified Optional.</h6></div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2">

                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($itemCondition)? route('item-conditions.update', $itemCondition->slug) : route('item-conditions.store') }}" id="item_condition_registration_form"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="{{ isset($itemCondition)? 'PUT' : 'POST' }}" required>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Item Condition Name</label>


                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ isset($itemCondition)? $itemCondition->name : old('name') }}"
                                       required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Item Condition Description </label>

                                <textarea class="form-control" name="description" id="description" rows="7" required>{{ isset($itemCondition)? $itemCondition->description : '' }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i>
                                    {{ isset($itemCondition)? 'UPDATE ITEM CONDITION' : 'SAVE ITEM CONDITION' }}
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
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function () {


            /*Jquery  Form Validations rules*/
            $("#item_condition_registration_form").validate({

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

                        name: {
                            required:true
                        },

                        description: {
                            required:true
                        }


                    },
                    messages: {

                        name: {
                            required:"The Item Condition Name is required"
                        },

                        description: {
                            required:"The Item Condition Description is required"
                        }


                    }

                } );

        });

    </script>

@endsection
