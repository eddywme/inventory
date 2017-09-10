@extends('layouts.app')
@section('title', 'Admin')
@section('styles')
    <link href="{{ asset('assets/css/admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/metisMenu.min.css') }}" rel="stylesheet">
    <style>
        .panel-blue {
            border-color: #1883ee;
        }
        .panel-blue > .panel-heading {
            border-color:#1883ee;
            color: white;
            background-color: #1883ee;
        }
        .panel-sky-blue > a {
            color: #1883ee;
        }
        .panel-sky-blue > a:hover {
            color: #3b6268;
        }

        .panel-sky-blue {
            border-color: #15c8ee;
        }
        .panel-sky-blue > .panel-heading {
            border-color: #16c5ee;
            color: white;
            background-color: #1abaee;
        }
        .panel-sky-blue > a {
            color: #16a3ee;
        }
        .panel-sky-blue > a:hover {
            color: #3b6268;
        }



        .admin-main{
            margin-bottom: 100px;
        }


    </style>
@endsection
@section('content')



    <div id="wrapper" class="admin-main">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/admin') }}">ADMIN PANEL</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li>
                    <a  href="#">
                        <i class="fa fa-server fa-fw"></i>  {{ strtoupper(Auth::user()->role->name) }}
                    </a>

                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="{{ route('users.index') }}"><i class="fa fa-user fa-fw"></i>  Users <span class="badge pull-right">{{ $numberOfUsers }}</span></a>
                        </li>

                        <li>
                            <a href="{{ route('assign.list') }}"><i class="fa fa-book fa-fw"></i>  Assigned Items <span class="badge pull-right">{{ $numberOfItemAssigned }}</span></a>
                        </li>

                        <li>
                            <a href="{{ route('item-accessories') }}"><i class="fa fa-suitcase"> </i> Items Accessories <span class="badge pull-right">{{ $numberOfItemAccessories }}</span> </a>
                        </li>

                        @if(App\Utility\Utils::isSuperAdmin())
                            <li>
                                <a href="{{ route("assignToken.get") }}"><i class="fa fa-key fa-fw"></i> Assign API Token</a>
                            </li>
                        @endif


                        <li>
                            <a href="{{ route("items.create") }}"><i class="fa fa-plus fa-fw"></i> Add Item</a>
                        </li>

                        <li>
                            <a href="{{ route('item-categories.create') }}"><i class="fa fa-plus-circle fa-fw"></i> Add Category</a>
                        </li>


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfUsers }}</div>
                                    <div>All Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('users.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-ticket fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfItems }}</div>
                                    <div>All Items</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('items-admin') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfItemAssigned }}</div>
                                    <div>Assigned Items</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('assign.list') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-blue">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-adjust fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfItemCategories }}</div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('item-categories.index') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfItemRequests }}</div>
                                    <div>Requests</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('request.list') }}">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-suitcase fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{ $numberOfItemAccessories }}</div>
                                    <div>Accessories</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                @if(\App\Utility\Utils::isSuperAdmin())
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-sky-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-cloud fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $numberOfApiSubscriptions }}</div>
                                        <div>Api Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('api.index') }}">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif



            </div>
            <!-- /.row -->
            <div class="row">


                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications Panel
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                @if( isset($lastItemAssignment->assigned_at) && isset($lastItem->created_at)  && isset( $lastUser->created_at) && isset($lastItemAccessory->created_at))
                                <a href="{{ route('assign.list') }}" class="list-group-item">
                                    <i class="fa fa-ticket fa-fw"></i> Last Item Was Assigned
                                    <span class="pull-right text-muted small"><em>{{ (new \Carbon\Carbon($lastItemAssignment->assigned_at) )->diffForHumans() }}</em>
                                    </span>
                                </a>
                                <a href="{{ route('items.show', $lastItem->slug) }}" class="list-group-item">
                                    <i class="fa fa-phone fa-fw"></i> New Item Was Added
                                    <span class="pull-right text-muted small"><em>{{ (new \Carbon\Carbon($lastItem->created_at) )->diffForHumans() }}</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-user fa-fw"></i> New User Was Registered
                                    <span class="pull-right text-muted small"><em>{{ (new \Carbon\Carbon($lastUser->created_at) )->diffForHumans() }}</em>
                                    </span>
                                </a>
                                <a href="{{ route('item-accessories.show', $lastItemAccessory->slug) }}" class="list-group-item">
                                    <i class="fa fa-tablet fa-fw"></i> Last Item Accessory Was Registered
                                    <span class="pull-right text-muted small"><em>{{ (new \Carbon\Carbon($lastItemAccessory->created_at) )->diffForHumans() }}</em>
                                    </span>
                                </a>
                                @else
                                    <a href="" class="list-group-item">
                                        <i class="fa fa-tablet fa-fw"></i> No Notifications
                                        <span class="pull-right text-muted small"><em></em>
                                    </span>
                                    </a>
                                @endif

                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->


                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/admin.min.js') }}"></script>
    <script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>

@endsection