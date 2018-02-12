<div class="tab-pane fade in" id="archive">
<br/>
	@if(count($archives) > 0)
    	<table id="printfiles" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Archived Date</th>
                    <th>Label Type</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
		    	@foreach($archives as $archive)
		    		<tr>
                        <td><a href="/portal/label/order/{{$archive->order_id}}">{{$archive->order_id}}</a></td>
                        <td>{{$archive->updated_at}}</td>
                        <td>{{$archive->type}}</td>
                        <td>{{$archive->quantity}}</td>
                        <td>
                            <a class="btn btn-default btn-sm" onclick="printZPL({{$archive->id}});">Print</a>
                        </td>
                    </tr>
		    	@endforeach
		    </tbody>
		</table>
	@else
	<h5 class="alert alert-info">There are no archived files.</h5>
	@endif		
</div>