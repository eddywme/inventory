@extends('layouts.app')
@section('title')
    {{ $itemAccessory->name  }}
@endsection
@section('styles')
    <link href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lightbox.min.css') }}" rel="stylesheet">
    <style>
        .main-content{
            background: #fff;
        }
        .item-search-form{
            margin: 50px;
        }
        .item-info{
            margin: 20px;
        }

        .btn-request{
            width: 100%;
            margin-top: 20px;
        }
        .accessory-detail-table{
            margin-top: 60px;
        }

    </style>
@endsection
@section('content')
    <div class="container">



        <div class="row main-content">
            <div class="col-md-12">

                <h3>Item Accessory Details Info</h3>

                    <div class="row item-info">
                        <hr>
                        <div class="col-md-4">
                            <p> <h4>Accessory Name: <strong>{{ $itemAccessory->name }}</strong> </h4>   <h5>Item Name: <strong>  <a href="{{ route('items.show', $itemAccessory->item->slug) }}">{{ $itemAccessory->item->name }}</a></strong> </h5></p><br>

                            @php
                                /*

                                 The number 7 is the convenience for the final url
                                 Which will go look into the public folder 'public = 7 chars'
                                 The idea is to save the image into the public folder
                                 By respecting the changes done by the symlinks operation

                                 asset('storage/'.substr($itemAccessory->photo_url,7))
                                 */
                            @endphp

                            <a
                                    class="example-image-link"
                                    href="{{ isset($itemAccessory->photo_url)? asset('storage/'.substr($itemAccessory->photo_url,7)) : asset('assets/images/No_image_available.png') }}"
                                    data-lightbox="example-1">

                                <img src="{{ isset($itemAccessory->photo_url)? asset('storage/'.substr($itemAccessory->photo_url,7)) : asset('assets/images/No_image_available.png') }}" class="img-thumbnail item-img-show">


                            </a>




                        </div>

                        <div class="col-md-8 "><br>
                            <div class="table-responsive accessory-detail-table" >
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ITEM PROPERTY</th><th>ITEM VALUE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> NAME</td> <td class="item_value_column">{{ $itemAccessory->name }}</td>
                                    </tr>

                                    <tr>
                                        <td> BELONGS TO ITEM  </td> <td class="item_value_column">{{ $itemAccessory->item->name }}</td>
                                    </tr>



                                    <tr>
                                        <td> DESCRIPTION</td>
                                        <td class="item_value_column">{{ $itemAccessory->description }}</td>
                                    </tr>



                                    </tbody>
                                </table>
                            </div> <!--table responsive-->

                            @if(\Illuminate\Support\Facades\Auth::check())

                                @if(\App\Utility\RoleUtils::isSystemPersonnel())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>


                                            @if($itemAccessory->item->is_available())
                                                <th>
                                                    <a href="{{ route('item-accessories.edit', $itemAccessory->slug) }}" class="btn btn-info"><strong><span class="fa fa-edit"> </span>&nbsp;EDIT ACCESSORY</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                </th>
                                                <th>
                                                    {{--<a href="" class="btn btn-danger "><strong><span class="fa fa-remove"> </span>&nbsp;REMOVE</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;--}}

                                                    <form  action="{{ route('item-accessories.destroy', $itemAccessory->slug) }}" method="POST" style="display: table-cell;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        {{ csrf_field() }}
                                                        <button class="btn btn-danger"
                                                                data-toggle="confirm"
                                                                data-title="Item Accessory deletion"
                                                                data-message="Do you really want to delete the Item Accessory ? <br>
                                                 Once the Item Accessory is deleted all its related data are deleted and the action cannot be reverted back.<br>"
                                                                data-type="danger">REMOVE
                                                            <span class="fa fa-trash"></span>
                                                        </button>
                                                    </form>
                                                </th>
                                            @endif


                                        </tr>

                                        </thead>
                                    </table>
                                </div>

                                @endif

                            @endif
                        </div> <!--col - md -8-->


                    </div>


            </div>




        </div>
        </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/lightbox.min.js') }}"></script>
@endsection

