<div class="booking-dash-section">
<table class="table table-striped dataTable">
<thead>
<tr role="row">
<th class="sorting">Name</th>
<th class="sorting">Type</th>
<th class="sorting">Price</th>
<th class="sorting">Status</th>
</tr>
</thead>
<tbody>
@if($daily->count()>0)
@foreach($daily as $i)
<tr role="row">
		<td >{{$i->Title}}</td>
		<td >{{$i->Type}}</td>
		<td >{{$i->DayFee}}</td>
		<td >{{getStatusName($i->status)}}</td>
</tr>
@endforeach
@else
<tr  role="row">
<td colspan="4">no Daily spaces</td>
</tr>
@endif
</tbody>
</table>
</div>

<!-- /.row -->
