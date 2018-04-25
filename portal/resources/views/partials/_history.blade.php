<div class="col-md-10 col-sm-12 col-xs-12">
    @if(count($tickets) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Printed Label History
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Printed Date</th>
                                <th>Type</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tickets as $ticket)
                             <tr>
                                <td><a href="{{ action('OrderController@orderdetails', ['id' => $$ticket->order_id]) }}">{{$ticket->order_id}}</a></td>
                                <td>{{$ticket->created_at}}</td>
                                <td>{{ucfirst(trans($ticket->type))}}</td>
                                <td>{{$ticket->quantity}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger col-md-6">
                No label history found.
        </div>
    @endif
</div>