@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h4 class="page-header">
            Dashboard
        </h4>
    </div>

    @include('errors.error-list')

    <!--Pending Order List-->
    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
            Orders
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Supplier</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ action('OrderController@orderdetails', ['id' => $order['order_number']]) }}">
                                    {{$order['order_number']}}
                                    </a>
                                </td>
                                <td>{{ucwords(strtolower($order['supplier']))}}</td>
                                <td>{{$order['approval_date']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        <a href="{{ action('OrderController@orderlist') }}">View more <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Order List-->
    <!--account settings-->
    <accountsetting user="{{ json_encode($user)}}"></accountsetting>
    <!--end account settings-->

    <!--label history-->
    @include('partials._history')
    <!--End label history-->
</div>
@stop