@extends('layouts.app')
@section('title')
    {{ isset($item)? 'Edit Item' : 'Registering an Item' }}
@endsection
@section('styles')
    <link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/simplemde.min.css') }}" rel="stylesheet">
    <style>
        .register-panel{
            margin-top: 40px;
            margin-bottom: 10px;
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
                <div class="panel-heading"><h3 align="center">{{ isset($item)?  'EDIT ITEM' : 'REGISTERING AN ITEM' }}</h3>
                <h6 align="center">All The Fields Are Required Unless Specified Optional.</h6></div>
                <div class="panel-body">

                    <div class="col-md-8 col-md-offset-2">

                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($item)? route('items.update', $item->slug) : route('items.store') }}" id="item_registration_form"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="_method" value="{{ isset($user)? 'PUT' : 'POST' }}" required>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Item Name</label>


                                <input id="name" type="text" class="form-control" name="name"
                                       value="{{ isset($item)? $item->name : old('name') }}"
                                       required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description">Item Description </label>

                                <textarea class="form-control" name="description" id="description" required></textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                        </div>


                        <div class="form-group">
                            <h5>Item Time Span </h5>



                                <label>
                                    <select name="num_hours"  id="num_hours" class="form-control" required>

                                        <?php for($i = 1; $i<24; $i++): ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php endfor;?>

                                    </select>Hours
                                </label>
                                <label>
                                    <select name="num_days"  id="num_days" class="form-control" required>

                                        <?php for($i = 0; $i<30; $i++): ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php endfor;?>

                                    </select>Days
                                </label>
                                <label>
                                    <select name="num_months" id="num_months" class="form-control" required>

                                        <?php for($i = 0; $i<12; $i++): ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php endfor;?>

                                    </select>Months
                                </label>
                                <label>
                                    <select name="num_years" id="num_years" class="form-control" required>

                                        <?php for($i = 0; $i<6; $i++): ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php endfor;?>

                                    </select>Years
                                </label>




                        </div>


                        <div class="form-group{{ $errors->has('photo_url') ? ' has-error' : '' }}">
                            <label for="photo_url" >Upload Photo [MAX 2MB] (Optional)</label>

                                <input type="file" class="form-control" name="photo_url" id="photo_url" data-max-size="2048" accept="image/*" />
                                @if ($errors->has('photo_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo_url') }}</strong>
                                    </span>
                                @endif

                        </div>



                        <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }}">
                            <label for="serial_number" >Item Serial Number </label>

                                <input type="text" name="serial_number" id="serial_number" class="form-control"
                                       value="{{ isset($item)? $item->serial_number : old('serial_number') }}"    required/>

                                @if ($errors->has('serial_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serial_number') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group{{ $errors->has('identifier') ? ' has-error' : '' }}">
                            <label for="identifier" >Item Identifier Tag </label>

                                <input type="text" name="identifier" id="identifier" class="form-control" required
                                       value="{{ isset($item)? $item->identifier : old('identifier') }}" />

                                @if ($errors->has('identifier'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('identifier') }}</strong>
                                    </span>
                                @endif

                        </div>


                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category" >Item Category : </label>

                            <select class="form-control" name="category_id" id="category" required >
                                @foreach($categories as $category)
                                    <option value="{{ $category->id}}" {{ isset($item)? ($category->id == $item->category_id)? 'selected':'' :  old('category_id') }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="help-block">
                                        <i>{{ $errors->first('category_id') }}</i>
                                    </span>
                            @endif

                        </div>


                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price">Item Price </label>

                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" name="price" id="price" class="form-control" required
                                           value="{{ isset($item)? $item->price : old('price') }}" />
                                </div>

                            @if ($errors->has('price'))
                                <span class="help-block">
                                        <i>{{ $errors->first('price') }}</i>
                                    </span>
                            @endif



                        </div>


                        <div class="form-group{{ $errors->has('condition_id') ? ' has-error' : '' }}">
                            <label for="condition">Item Condition </label>

                            <select class="form-control" name="condition_id" id="condition" required >
                                @foreach($conditions as $condition)
                                    <option value="{{ $condition->id}}" {{ isset($item)? ($condition->id == $item->condition_id)? 'selected':'' : old('condition_id') }}>{{ $condition->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('condition_id'))
                                <span class="help-block">
                                        <i>{{ $errors->first('condition_id') }}</i>
                                    </span>
                            @endif


                        </div >


                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" >Item Location </label>

                                <input type="text" name="location" id="location" class="form-control" required
                                       value="{{ isset($item)? $item->location : old('location') }}"/>

                            @if ($errors->has('location'))
                                <span class="help-block">
                                        <i>{{ $errors->first('location') }}</i>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('owned_by') ? ' has-error' : '' }}">
                            <label for="owned_by">Item Owned By </label>

                            <select class="form-control" name="owned_by" id="owned_by" required >
                                @foreach($users as $user)
                                    <option value="{{ $user->id}}" {{ isset($item)? ($user->id === $item->owned_by)? 'selected':'' : old('owned_by') }}>{{ $user->first_name." ". $user->last_name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('owned_by'))
                                <span class="help-block">
                                        <i>{{ $errors->first('owned_by') }}</i>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('model_number') ? ' has-error' : '' }}">
                            <label for="model_number" >Item Model Number </label>

                                <input type="text" name="model_number" id="model_number" class="form-control" required
                                       value="{{ isset($item)? $item->model_number : old('model_number') }}"/>

                            @if ($errors->has('model_number'))
                                <span class="help-block">
                                        <i>{{ $errors->first('model_number') }}</i>
                                    </span>
                            @endif

                        </div>


                        <div class="form-group">
                            <label for="item_date_acquired" >Item Date Acquired </label>

                                <div class='input-group date' id='date_acquired'>
                                    <input type='text' class="form-control" id="date_acquired" name="date_acquired"
                                           value="{{  isset($item)? $item->date_acquired : old('date_acquired') }}" required/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                            </div>
                        </div>




                        <div class="form-group">

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i>
                                    {{ isset($item)? 'UPDATE ITEM' : 'SAVE ITEM' }}
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
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>

    <script>
        $(document).ready(function () {


            /*Jquery  Form Validations rules*/
            $("#item_registration_form").validate({

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
                        },


                        quantity: {
                            required: true

                        },

                        price: {
                            required: true,
                            number : true

                        },

                        identifier: {
                            required: true

                        },

                        serial_number: {
                            required: true

                        },


                        category: {
                            required: true

                        },

                        condition: {
                            required: true

                        },

                        location: {
                            required: true

                        },

                        owned_by: {
                            required: true

                        },

                        model_number: {
                            required: true

                        },

                        date_acquired: {
                            required: true

                        }




                    },
                    messages: {

                        name: {
                            required:"The Item Name is required"
                        },

                        description: {
                            required:"The Item Description is required"
                        },

                        quantity: {
                            required: "The Item Quantity is required"

                        },

                        price: {
                            required: "The item price is required"

                        },

                        serial_number: {
                            required: "The Item Serial Number is required"

                        },




                        category: {
                            required: "The Item Category is required"

                        },

                        identifier: {
                            required: "The Item Identifier is required"

                        },

                        condition: {
                            required: "The Item Condition is required"

                        },

                        location: {
                            required: "The Item Location is required"

                        },

                        owned_by: {
                            required: "The Item Owner name is required"

                        },

                        model_number: {
                            required: "The Item model number is required"

                        },

                        date_acquired: {
                            required: "The Item date acquired is required"

                        }



                    }

                } );


            $(function () {
                /* Date-time picker codes*/
                $('#date_acquired').datetimepicker({
                    defaultDate: new Date(),
                    format: 'YYYY-MM-DD HH:mm:ss',
                    showClear: true
                });

            });

        });

    </script>

@endsection
