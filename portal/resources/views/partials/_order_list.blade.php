<div class="col-md-10 col-sm-12 col-xs-12">
@if(isset($orders))
    @if(count($orders) > 0)
        <div class="panel panel-default">
           <!--  <div class="panel-heading">
                Order List
            </div> -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Supplier</th>
                                <th>Order Date</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a href="{{ action('OrderController@orderdetails', ['id' => $order['order_number']]) }}">{{$order['order_number']}}</a></td>
                                <td>{{ucwords(strtolower($order['supplier']))}}</td>
                                <td>{{$order['approval_date']}}</td>
                                <td><a class='btn btn-default btn-xs' href="{{ action('OrderController@download', ['id' => $order['order_number'], 'format' => 'xml']) }}" href="/portal/label/order/download/{{$order['order_number']}}/xml">XML</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger col-md-6">
            No orders found.
        </div>
    @endif
@endif
</div>