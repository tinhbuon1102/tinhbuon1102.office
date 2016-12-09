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
@if($weekly->count()>0)
@foreach($weekly as $i)
<tr role="row">
		<td >{{$i->Title}}</td>
		<td >{{$i->Type}}</td>
		<td >{{$i->WeekFee}}</td>
		<td >{{getStatusName($i->status)}}</td>
</tr>
@endforeach
@else
<tr  role="row">
<td colspan="4">no Weekly spaces</td>
</tr>
@endif
</tbody>
</table>
</div>

<!-- /.row -->
