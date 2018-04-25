<div class="tab-pane fade active in" id="carton">
    <form action="{{ action('LabelController@createticket') }}" method="post">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <input name="type" class="form-control" type="hidden" value="carton">
    <!-- Carton -->
    <div class="col-xs-12">
    @if(!empty($orderdetails['cartonpack']))
        <h4>Carton Pack - {{$order_no}}</h4>
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="label_options">
                <thead>
                    <tr>
                        <th>Style</th>
                        <th>Item Number</th>
                        <th>Description</th>
                        <th>Pack Quantity</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Over Print</th>
                        <th data-type="pack">Select (<a href="#" class="selectall">All</a>/<a href="#" class="selectnone">None</a>)</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($orderdetails['cartonpack'] as $order)
                    <tr>
                        <input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][location_type]" type="hidden" value="{{$order['location_type']}}">
                        <input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][location]" type="hidden" value="{{$order['location']}}">
                        <input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][item]" type="hidden" value="{{$order['item']}}">
                        <input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][order_no]" type="hidden" value="{{$order['order_number']}}">
                        <td>{{$order['style']}}</td>
                        <td>{{$order['item']}}</td>
                        <td>{{$order['description']}}</td>
                        <td class="col-xs-1">{{$order['pick_location'] or '6'}}</td>
                        <td class="col-xs-1">Pack - {{$order['pack_type']}}</td>
                        <td class="col-xs-1"><input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][qty]" type="text" value="{{$order['quantity']}}" required></td>
                        <td class="col-xs-1"><input class="form-control {{$order['item']}}" name="data[{{$order['item']}}][over_print_qty]" type="number" value="0" required></td>
                        <td class="col-xs-1"><input type="checkbox" id="btn_select_check" class="pack" data-item="{{$order['item']}}" checked></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
    @else
    <h4>Carton Pack</h4>
        <div class="alert alert-danger col-md-6">
            No carton labels to print for this order.
        </div>
    @endif
    </div>
    <div class="col-xs-12">
        @if(!empty($orderdetails['cartonloose']))
            <h4>Carton Loose - {{$order_no}}</h4>
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="label_options">
                    <thead>
                        <tr>
                            <th>Style</th>
                            <th>Item Number</th>
                            <th>Description</th>
                            <th>Carton Quantity</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Over Print</th>
                            <th data-type="loose">Select (<a href="#" class="selectall">All</a>/<a href="#" class="selectnone">None</a>)</th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach ($orderdetails['cartonloose'] as $order)
                    <tr>
                        <input name="data[{{$order['item']}}][location_type]" class="form-control {{$order['item']}}" type="hidden" value="{{$order['location_type']}}">
                        <input name="data[{{$order['item']}}][location]" class="form-control {{$order['item']}}" type="hidden" value="{{$order['location']}}">
                        <input name="data[{{$order['item']}}][item]" class="form-control {{$order['item']}}" type="hidden" value="{{$order['item']}}">
                        <input name="data[{{$order['item']}}][order_no]" class="form-control {{$order['item']}}" type="hidden" value="{{$order['order_number']}}">
                        <td>{{$order['style']}}</td>
                        <td>{{$order['item']}}</td>
                        <td>{{$order['description']}}</td>
                        <td class="col-xs-1">{{$order['pick_location']}}</td>
                        <td class="col-xs-1">Loose</td>
                        <td class="col-xs-1"><input name="data[{{$order['item']}}][qty]" class="form-control {{$order['item']}}" type="text" value="{{$order['quantity']}}" required></td>
                        <td class="col-xs-1"><input name="data[{{$order['item']}}][over_print_qty]" class="form-control {{$order['item']}}" type="number" value="0" required></td>
                        <td class="col-xs-1"><input type="checkbox" id="btn_select_check" class="loose" data-item="{{$order['item']}}" checked></td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                </div>
        @else
            <h4>Carton Loose</h4>
            <div class="alert alert-danger col-md-6">
                No carton labels to print for this order.
            </div>
        @endif
</div>
    @if (!empty($orderdetails['cartonpack']) || !empty($orderdetails['cartonloose']))
        <button type="submit" class="btn btn-primary btn-sm pull-right">Save &amp; Generate</button>
    @endif
    </form>
</div>